/*  Annotator Touch Plugin - v1.1.1
 *  Copyright 2012-2013, Compendio <www.compendio.ch>
 *  Released under the MIT license
 *  More Information: https://github.com/aron/annotator.touch.js
 */
(function () {
    var __bind = function (fn, me) {
        return function () {
            return fn.apply(me, arguments);
        };
    },
            __hasProp = Object.prototype.hasOwnProperty,
            __extends = function (child, parent) {
                for (var key in parent) {
                    if (__hasProp.call(parent, key))
                        child[key] = parent[key];
                }
                function ctor() {
                    this.constructor = child;
                }
                ctor.prototype = parent.prototype;
                child.prototype = new ctor;
                child.__super__ = parent.prototype;
                return child;
            };

    Annotator.Plugin.Touch = (function (_super) {
        var jQuery, _t;

        __extends(Touch, _super);

        _t = Annotator._t;

        jQuery = Annotator.$;

        Touch.states = {
            ON: "on",
            OFF: "off"
        };

        Touch.prototype.template = "<div class=\"annotator-touch-widget annotator-touch-controls annotator-touch-hide\">\n  <div class=\"annotator-touch-widget-inner\">\n    <a class=\"annotator-button annotator-add annotator-focus\">" + _t("Annotate") + "</a>\n<a class=\"annotator-button annotator-touch-toggle\" data-state=\"off\">" + _t("Start Annotating") + "</a>\n  </div>\n</div>";

        Touch.prototype.classes = {
            hide: "annotator-touch-hide"
        };

        Touch.prototype.options = {
            force: false,
            useHighlighter: false
        };

        function Touch(element, options) {
            this._onDocumentTap = __bind(this._onDocumentTap, this);
            this._onHighlightTap = __bind(this._onHighlightTap, this);
            this._onAdderTap = __bind(this._onAdderTap, this);
            this._onToggleTap = __bind(this._onToggleTap, this);
            this._onSelection = __bind(this._onSelection, this);
            this._watchForSelection = __bind(this._watchForSelection, this);
            Touch.__super__.constructor.apply(this, arguments);
            this.utils = Annotator.Plugin.Touch.utils;
            this.selection = null;
            this.document = jQuery(document);
        }

        Touch.prototype.pluginInit = function () {
            if (!(Annotator.supported() && (this.options.force || Touch.isTouchDevice()))) {
                return;
            }
            this._setupControls();
            if (this.options.useHighlighter) {
                this.showControls();
                this.highlighter = new Highlighter({
                    root: this.element[0],
                    prefix: "annotator-selection",
                    enable: false,
                    highlightStyles: true
                });
            }
            this.document.delegate(".annotator-hl", "tap", {
                preventDefault: false
            }, this._onHighlightTap);
            this.subscribe("selection", this._onSelection);
            this._unbindAnnotatorEvents();
            this._setupAnnotatorEvents();
            return this._watchForSelection();
        };

        Touch.prototype.pluginDestroy = function () {
            if (this.controls)
                this.controls.remove();
            if (this.highlighter)
                this.highlighter.disable();
            if (this.annotator) {
                return this.annotator.editor.unsubscribe("hide", this._watchForSelection);
            }
        };

        Touch.prototype.startAnnotating = function () {
            if (this.highlighter)
                this.highlighter.enable();
            this.toggle.attr("data-state", Touch.states.ON);
            this.toggle.html("Stop Annotating");
            return this;
        };

        Touch.prototype.stopAnnotating = function () {
            if (this.highlighter)
                this.highlighter.disable();
            this.toggle.attr("data-state", Touch.states.OFF);
            this.toggle.html("Start Annotating");
            return this;
        };

        Touch.prototype.isAnnotating = function () {
            var usingHighlighter;
            usingHighlighter = this.options.useHighlighter;
            return !usingHighlighter || this.toggle.attr("data-state") === Touch.states.ON;
        };

        Touch.prototype.showEditor = function (annotation) {
            this.annotator.showEditor(annotation, {});
            this.hideControls();
            return this;
        };

        Touch.prototype.showControls = function () {
            this.controls.removeClass(this.classes.hide);
            return this;
        };

        Touch.prototype.hideControls = function () {
            if (!this.options.useHighlighter)
                this.controls.addClass(this.classes.hide);
            return this;
        };

        Touch.prototype._setupControls = function () {
            this.annotator.adder.remove();
            this.controls = jQuery(this.template).appendTo("body");
            this.adder = this.controls.find(".annotator-add");
            this.adder.bind("tap", {
                onTapDown: function (event) {
                    return event.stopPropagation();
                }
            }, this._onAdderTap);
            this.toggle = this.controls.find(".annotator-touch-toggle");
            this.toggle.bind({
                "tap": this._onToggleTap
            });
            if (!this.options.useHighlighter)
                return this.toggle.hide();
        };

        Touch.prototype._setupAnnotatorEvents = function () {
            var _this = this;
            this.editor = new Touch.Editor(this.annotator.editor);
            this.viewer = new Touch.Viewer(this.annotator.viewer);
            this.annotator.editor.on("show", function () {
                _this._clearWatchForSelection();
                _this.annotator.onAdderMousedown();
                if (_this.highlighter)
                    return _this.highlighter.disable();
            });
            this.annotator.viewer.on("show", function () {
                if (_this.highlighter)
                    return _this.highlighter.disable();
            });
            this.annotator.editor.on("hide", function () {
                return _this.utils.nextTick(function () {
                    if (_this.highlighter)
                        _this.highlighter.enable().deselect();
                    return _this._watchForSelection();
                });
            });
            return this.annotator.viewer.on("hide", function () {
                return _this.utils.nextTick(function () {
                    if (_this.highlighter)
                        return _this.highlighter.enable().deselect();
                });
            });
        };

        Touch.prototype._unbindAnnotatorEvents = function () {
            this.document.unbind({
                "mouseup": this.annotator.checkForEndSelection,
                "mousedown": this.annotator.checkForStartSelection
            });
            return this.element.unbind("click mousedown mouseover mouseout");
        };

        Touch.prototype._watchForSelection = function () {
            var interval, start, step,
                    _this = this;
            if (this.timer)
                return;
            interval = Touch.isAndroid() ? 300 : 1000 / 60;
            start = new Date().getTime();
            step = function () {
                var progress;
                progress = (new Date().getTime()) - start;
                if (progress > interval) {
                    start = new Date().getTime();
                    _this._checkSelection();
                }
                return _this.timer = _this.utils.requestAnimationFrame.call(window, step);
            };
            return step();
        };

        Touch.prototype._clearWatchForSelection = function () {
            this.utils.cancelAnimationFrame.call(window, this.timer);
            return this.timer = null;
        };

        Touch.prototype._checkSelection = function () {
            var previous, selection, string;
            selection = window.getSelection();
            previous = this.selectionString;
            string = jQuery.trim(selection + "");
            if (selection.rangeCount && string !== this.selectionString) {
                this.range = selection.getRangeAt(0);
                this.selectionString = string;
            }
            if (selection.rangeCount === 0 || (this.range && this.range.collapsed)) {
                this.range = null;
                this.selectionString = "";
            }
            if (this.selectionString !== previous) {
                return this.publish("selection", [this.range, this]);
            }
        };

        Touch.prototype._onSelection = function () {
            if (this.isAnnotating() && this.range && this._isValidSelection(this.range)) {
                this.adder.removeAttr("disabled");
                return this.showControls();
            } else {
                this.adder.attr("disabled", "");
                return this.hideControls();
            }
        };

        Touch.prototype._isValidSelection = function (range) {
            var inElement, isStartOffsetValid, isValidEnd, isValidStart;
            inElement = function (node) {
                return jQuery(node).parents('.annotator-wrapper').length;
            };
            isStartOffsetValid = range.startOffset < range.startContainer.length;
            isValidStart = isStartOffsetValid && inElement(range.startContainer);
            isValidEnd = range.endOffset > 0 && inElement(range.endContainer);
            return isValidStart || isValidEnd;
        };

        Touch.prototype._onToggleTap = function (event) {
            event.preventDefault();
            if (this.isAnnotating()) {
                return this.stopAnnotating();
            } else {
                return this.startAnnotating();
            }
        };

        Touch.prototype._onAdderTap = function (event) {
            var browserRange, onAnnotationCreated, range,
                    _this = this;
            event.preventDefault();
            if (this.range) {
                browserRange = new Annotator.Range.BrowserRange(this.range);
                range = browserRange.normalize().limit(this.element[0]);
                if (range && !this.annotator.isAnnotator(range.commonAncestor)) {
                    onAnnotationCreated = function (annotation) {
                        _this.annotator.unsubscribe('beforeAnnotationCreated', onAnnotationCreated);
                        annotation.quote = range.toString();
                        return annotation.ranges = [range];
                    };
                    this.annotator.subscribe('beforeAnnotationCreated', onAnnotationCreated);
                    return this.annotator.onAdderClick(event);
                }
            }
        };

        Touch.prototype._onHighlightTap = function (event) {
            var clickable, original;
            clickable = jQuery(event.currentTarget).parents().filter(function () {
                return jQuery(this).is('a, [data-annotator-clickable]');
            });
            if (clickable.length)
                return;
            if (jQuery.contains(this.element[0], event.currentTarget)) {
                original = event.originalEvent;
                if (original && original.touches) {
                    event.pageX = original.touches[0].pageX;
                    event.pageY = original.touches[0].pageY;
                }
                if (this.annotator.viewer.isShown())
                    this.annotator.viewer.hide();
                this.annotator.onHighlightMouseover(event);
                this.document.unbind("tap", this._onDocumentTap);
                return this.document.bind("tap", {
                    preventDefault: false
                }, this._onDocumentTap);
            }
        };

        Touch.prototype._onDocumentTap = function (event) {
            if (!this.annotator.isAnnotator(event.target))
                this.annotator.viewer.hide();
            if (!this.annotator.viewer.isShown()) {
                return this.document.unbind("tap", this._onDocumentTap);
            }
        };

        Touch.isTouchDevice = function () {
            return ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;
        };

        Touch.isAndroid = function () {
            return /Android/i.test(window.navigator.userAgent);
        };

        return Touch;

    })(Annotator.Plugin);

    Annotator.Plugin.Touch.Editor = (function (_super) {
        var Touch, jQuery, _t;

        __extends(Editor, _super);

        _t = Annotator._t;

        jQuery = Annotator.$;

        Touch = Annotator.Plugin.Touch;

        Editor.prototype.events = {
            "click": "_onOverlayTap",
            ".annotator-save tap": "_onSubmit",
            ".annotator-cancel tap": "_onCancel",
            ".annotator-quote-toggle tap": "_onExpandTap"
        };

        Editor.prototype.classes = {
            expand: "annotator-touch-expand"
        };

        Editor.prototype.templates = {
            quote: "<button class=\"annotator-quote-toggle\">" + _t("expand") + "</button>\n<span class=\"quote\"></span>"
        };

        function Editor(editor, options) {
            var _this = this;
            this.editor = editor;
            this._onOverlayTap = __bind(this._onOverlayTap, this);
            this._onCancel = __bind(this._onCancel, this);
            this._onSubmit = __bind(this._onSubmit, this);
            this._onExpandTap = __bind(this._onExpandTap, this);
            this._triggerAndroidRedraw = __bind(this._triggerAndroidRedraw, this);
            Editor.__super__.constructor.call(this, this.editor.element[0], options);
            this.element.addClass("annotator-touch-editor");
            this.element.wrapInner('<div class="annotator-touch-widget" />');
            this.element.find("form").addClass("annotator-touch-widget-inner");
            this.element.find(".annotator-controls a").addClass("annotator-button");
            this.element.undelegate("textarea", "keydown");
            this.on("hide", function () {
                return _this.element.find(":focus").blur();
            });
            this._setupQuoteField();
            this._setupAndroidRedrawHack();
        }

        Editor.prototype.showQuote = function () {
            this.quote.addClass(this.classes.expand);
            this.quote.find("button").text(_t("Collapse"));
            return this;
        };

        Editor.prototype.hideQuote = function () {
            this.quote.removeClass(this.classes.expand);
            this.quote.find("button").text(_t("Expand"));
            return this;
        };

        Editor.prototype.isQuoteHidden = function () {
            return !this.quote.hasClass(this.classes.expand);
        };

        Editor.prototype._setupQuoteField = function () {
            var _this = this;
            this.quote = jQuery(this.editor.addField({
                id: 'quote',
                load: function (field, annotation) {
                    _this.hideQuote();
                    _this.quote.find('span').html(Annotator.Util.escape(annotation.quote || ''));
                    return _this.quote.find("button").toggle(_this._isTruncated());
                }
            }));
            this.quote.empty().addClass("annotator-item-quote");
            return this.quote.append(this.templates.quote);
        };

        Editor.prototype._setupAndroidRedrawHack = function () {
            var check, timer,
                    _this = this;
            if (Touch.isAndroid()) {
                timer = null;
                check = function () {
                    timer = null;
                    return _this._triggerAndroidRedraw();
                };
                return jQuery(window).bind("scroll", function () {
                    if (!timer)
                        return timer = setTimeout(check, 100);
                });
            }
        };

        Editor.prototype._triggerAndroidRedraw = function () {
            if (!this._input)
                this._input = this.element.find(":input:first");
            if (!this._default) {
                this._default = parseFloat(this._input.css("padding-top"));
            }
            this._multiplier = (this._multiplier || 1) * -1;
            this._input[0].style.paddingTop = (this._default + this._multiplier) + "px";
            return this._input[0].style.paddingTop = (this._default - this._multiplier) + "px";
        };

        Editor.prototype._isTruncated = function () {
            var expandedHeight, isHidden, truncatedHeight;
            isHidden = this.isQuoteHidden();
            if (!isHidden)
                this.hideQuote();
            truncatedHeight = this.quote.height();
            this.showQuote();
            expandedHeight = this.quote.height();
            if (isHidden) {
                this.hideQuote();
            } else {
                this.showQuote();
            }
            return expandedHeight > truncatedHeight;
        };

        Editor.prototype._onExpandTap = function (event) {
            event.preventDefault();
            event.stopPropagation();
            if (this.isQuoteHidden()) {
                return this.showQuote();
            } else {
                return this.hideQuote();
            }
        };

        Editor.prototype._onSubmit = function (event) {
            event.preventDefault();
            return this.editor.submit();
        };

        Editor.prototype._onCancel = function (event) {
            event.preventDefault();
            return this.editor.hide();
        };

        Editor.prototype._onOverlayTap = function (event) {
            if (event.target === this.element[0])
                return this.editor.hide();
        };

        return Editor;

    })(Annotator.Delegator);

    jQuery.event.special.tap = {
        add: function (eventHandler) {
            var context, data, onTapEnd, onTapStart;
            data = eventHandler.data = eventHandler.data || {};
            context = this;
            onTapStart = function (event) {
                if (data.preventDefault !== false)
                    event.preventDefault();
                if (data.onTapDown)
                    data.onTapDown.apply(this, arguments);
                data.event = event;
                data.touched = setTimeout(function () {
                    return data.touched = null;
                }, data.timeout || 300);
                return jQuery(document).bind({
                    touchend: onTapEnd,
                    mouseup: onTapEnd
                });
            };
            onTapEnd = function (event) {
                var handler;
                if (data.touched != null) {
                    clearTimeout(data.touched);
                    if (event.target === context || jQuery.contains(context, event.target)) {
                        handler = eventHandler.origHandler || eventHandler.handler;
                        handler.call(this, data.event);
                    }
                    data.touched = null;
                }
                if (data.onTapUp)
                    data.onTapUp.apply(this, arguments);
                return jQuery(document).unbind({
                    touchstart: onTapEnd,
                    mousedown: onTapEnd
                });
            };
            data.tapHandlers = {
                touchstart: onTapStart,
                mousedown: onTapStart
            };
            if (eventHandler.selector) {
                return jQuery(context).delegate(eventHandler.selector, data.tapHandlers);
            } else {
                return jQuery(context).bind(data.tapHandlers);
            }
        },
        remove: function (eventHandler) {
            return jQuery(this).unbind(eventHandler.data.tapHandlers);
        }
    };

    Annotator.Delegator.natives.push("touchstart", "touchmove", "touchend", "tap");

    Annotator.Plugin.Touch.utils = (function () {
        var cancelAnimationFrame, lastTime, prefix, requestAnimationFrame, vendors, _i, _len;
        vendors = ['ms', 'moz', 'webkit', 'o'];
        requestAnimationFrame = window.requestAnimationFrame;
        cancelAnimationFrame = window.cancelAnimationFrame;
        for (_i = 0, _len = vendors.length; _i < _len; _i++) {
            prefix = vendors[_i];
            if (!(!requestAnimationFrame))
                continue;
            requestAnimationFrame = window["" + prefix + "RequestAnimationFrame"];
            cancelAnimationFrame = window["" + prefix + "CancelAnimationFrame"] || window["" + prefix + "CancelRequestAnimationFrame"];
        }
        if (!requestAnimationFrame) {
            lastTime = 0;
            requestAnimationFrame = function (callback, element) {
                var currTime, timeToCall;
                currTime = new Date().getTime();
                timeToCall = Math.max(0, 16 - (currTime - lastTime));
                lastTime = currTime + timeToCall;
                return window.setTimeout((function () {
                    return callback(currTime + timeToCall);
                }), timeToCall);
            };
        }
        if (!cancelAnimationFrame) {
            cancelAnimationFrame = function (id) {
                return clearTimeout(id);
            };
        }
        return {
            requestAnimationFrame: requestAnimationFrame,
            cancelAnimationFrame: cancelAnimationFrame,
            nextTick: function (fn) {
                return setTimeout(fn, 0);
            }
        };
    })();

    Annotator.Plugin.Touch.Viewer = (function (_super) {
        var jQuery;

        __extends(Viewer, _super);

        jQuery = Annotator.$;

        Viewer.prototype.events = {
            ".annotator-item tap": "_onTap",
            ".annotator-edit tap": "_onEdit",
            ".annotator-delete tap": "_onDelete"
        };

        function Viewer(viewer, options) {
            this.viewer = viewer;
            this._onLoad = __bind(this._onLoad, this);
            Viewer.__super__.constructor.call(this, this.viewer.element[0], options);
            this.element.unbind("click");
            this.element.addClass("annotator-touch-widget annotator-touch-viewer");
            this.on("load", this._onLoad);
        }

        Viewer.prototype.hideAllControls = function () {
            this.element.find(".annotator-item").removeClass(this.viewer.classes.showControls);
            return this;
        };

        Viewer.prototype._onLoad = function () {
            var controls;
            controls = this.element.find(".annotator-controls");
            controls.toggleClass("annotator-controls annotator-touch-controls");
            return controls.find("button").addClass("annotator-button");
        };

        Viewer.prototype._onTap = function (event) {
            var isVisible, target;
            target = jQuery(event.currentTarget);
            isVisible = target.hasClass(this.viewer.classes.showControls);
            this.hideAllControls();
            if (!isVisible)
                return target.addClass(this.viewer.classes.showControls);
        };

        Viewer.prototype._onEdit = function (event) {
            event.preventDefault();
            return this.viewer.onEditClick(event);
        };

        Viewer.prototype._onDelete = function (event) {
            event.preventDefault();
            return this.viewer.onDeleteClick(event);
        };

        return Viewer;

    })(Annotator.Delegator);

}).call(this);
