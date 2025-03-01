(function (jQuery) {
    var daysInWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var shortMonthsInYear = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var longMonthsInYear = ['January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'];
    var shortMonthsToNumber = {'Jan': '01', 'Feb': '02', 'Mar': '03', 'Apr': '04', 'May': '05', 'Jun': '06',
        'Jul': '07', 'Aug': '08', 'Sep': '09', 'Oct': '10', 'Nov': '11', 'Dec': '12'};

    var values, values2, values3, hour;

    jQuery.format = (function () {
        function strDay(value) {
            return daysInWeek[parseInt(value, 10)] || value;
        }

        function strMonth(value) {
            var monthArrayIndex = parseInt(value, 10) - 1;
            return shortMonthsInYear[monthArrayIndex] || value;
        }

        function strLongMonth(value) {
            var monthArrayIndex = parseInt(value, 10) - 1;
            return longMonthsInYear[monthArrayIndex] || value;
        }

        var parseMonth = function (value) {
            return shortMonthsToNumber[value] || value;
        };

        var parseTime = function (value) {
            var retValue = value;
            var millis = '';
            if (retValue.indexOf('.') !== -1) {
                var delimited = retValue.split('.');
                retValue = delimited[0];
                millis = delimited[1];
            }

            values3 = retValue.split(':');

            if (values3.length === 3) {
                hour = values3[0];
                minute = values3[1];
                second = values3[2];
                return {
                    time: retValue,
                    hour: hour,
                    minute: minute,
                    second: second,
                    millis: millis
                };
            } else {
                return {
                    time: '',
                    hour: '',
                    minute: '',
                    second: '',
                    millis: ''
                };
            }
        };

        var padding = function (value, length) {
            var paddingCount = length - String(value).length;
            for (var i = 0; i < paddingCount; i++) {
                value = '0' + value;
            }
            return value;
        };

        var dateYYYYMMDDTimeRegexp = function () {
            return (/\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.?\d{0,3}[Z\-+]?(\d{2}:?\d{2})?/);
        };

        return {
            date: function (value, format) {
                /*
                 value = new java.util.Date()
                 => 2009-12-18 10:54:50.546
                 */
                try {
                    var date = null;
                    var year = null;
                    var month = null;
                    var dayOfMonth = null;
                    var dayOfWeek = null;
                    var time = null;
                    if (typeof value == 'number') {
                        return this.date(new Date(value), format);
                    } else if (typeof value.getFullYear == 'function') {
                        year = value.getFullYear();
                        month = value.getMonth() + 1;
                        dayOfMonth = value.getDate();
                        dayOfWeek = value.getDay();
                        time = parseTime(value.toTimeString());
                    } else if (value.search(dateYYYYMMDDTimeRegexp()) != -1) {
                        /* 2009-04-19T16:11:05+02:00 || 2009-04-19T16:11:05Z */
                        values = value.split(/[T\+-]/);
                        year = values[0];
                        month = values[1];
                        dayOfMonth = values[2];
                        time = parseTime(values[3].split('.')[0]);
                        date = new Date(year, month - 1, dayOfMonth);
                        dayOfWeek = date.getDay();
                    } else {
                        values = value.split(' ');
                        switch (values.length) {
                            case 6:
                                /* Wed Jan 13 10:43:41 CET 2010 */
                                year = values[5];
                                month = parseMonth(values[1]);
                                dayOfMonth = values[2];
                                time = parseTime(values[3]);
                                date = new Date(year, month - 1, dayOfMonth);
                                dayOfWeek = date.getDay();
                                break;
                            case 2:
                                /* 2009-12-18 10:54:50.546 */
                                values2 = values[0].split('-');
                                year = values2[0];
                                month = values2[1];
                                dayOfMonth = values2[2];
                                time = parseTime(values[1]);
                                date = new Date(year, month - 1, dayOfMonth);
                                dayOfWeek = date.getDay();
                                break;
                            case 7:
                            /* Tue Mar 01 2011 12:01:42 GMT-0800 (PST) */
                            case 9:
                            /* added by Larry, for Fri Apr 08 2011 00:00:00 GMT+0800 (China Standard Time) */
                            case 10:
                                /* added by Larry, for Fri Apr 08 2011 00:00:00 GMT+0200 (W. Europe Daylight Time) */
                                year = values[3];
                                month = parseMonth(values[1]);
                                dayOfMonth = values[2];
                                time = parseTime(values[4]);
                                date = new Date(year, month - 1, dayOfMonth);
                                dayOfWeek = date.getDay();
                                break;
                            case 1:
                                /* added by Jonny, for 2012-02-07CET00:00:00 (Doctrine Entity -> Json Serializer) */
                                values2 = values[0].split('');
                                year = values2[0] + values2[1] + values2[2] + values2[3];
                                month = values2[5] + values2[6];
                                dayOfMonth = values2[8] + values2[9];
                                time = parseTime(values2[13] + values2[14] + values2[15] + values2[16] + values2[17] + values2[18] + values2[19] + values2[20]);
                                date = new Date(year, month - 1, dayOfMonth);
                                dayOfWeek = date.getDay();
                                break;
                            default:
                                return value;
                        }
                    }
                    var pattern = '';
                    var retValue = '';
                    var unparsedRest = '';
                    var inQuote = false;
                    /* Issue 1 - variable scope issue in format.date (Thanks jakemonO) */
                    for (var i = 0; i < format.length; i++) {
                        var currentPattern = format.charAt(i);
                        if (inQuote) {
                            if (currentPattern == "'") {
                                retValue += (pattern === '') ? "'" : pattern;
                                pattern = '';
                                inQuote = false;
                            } else {
                                pattern += currentPattern;
                            }
                            continue;
                        }
                        pattern += currentPattern;
                        unparsedRest = '';
                        switch (pattern) {
                            case 'ddd':
                                retValue += strDay(dayOfWeek);
                                pattern = '';
                                break;
                            case 'dd':
                                if (format.charAt(i + 1) == 'd') {
                                    break;
                                }
                                retValue += padding(dayOfMonth, 2);
                                pattern = '';
                                break;
                            case 'd':
                                if (format.charAt(i + 1) == 'd') {
                                    break;
                                }
                                retValue += parseInt(dayOfMonth, 10);
                                pattern = '';
                                break;
                            case 'D':
                                if (dayOfMonth == 1 || dayOfMonth == 21 || dayOfMonth == 31) {
                                    dayOfMonth = parseInt(dayOfMonth, 10) + 'st';
                                } else if (dayOfMonth == 2 || dayOfMonth == 22) {
                                    dayOfMonth = parseInt(dayOfMonth, 10) + 'nd';
                                } else if (dayOfMonth == 3 || dayOfMonth == 23) {
                                    dayOfMonth = parseInt(dayOfMonth, 10) + 'rd';
                                } else {
                                    dayOfMonth = parseInt(dayOfMonth, 10) + 'th';
                                }
                                retValue += dayOfMonth;
                                pattern = '';
                                break;
                            case 'MMMM':
                                retValue += strLongMonth(month);
                                pattern = '';
                                break;
                            case 'MMM':
                                if (format.charAt(i + 1) === 'M') {
                                    break;
                                }
                                retValue += strMonth(month);
                                pattern = '';
                                break;
                            case 'MM':
                                if (format.charAt(i + 1) == 'M') {
                                    break;
                                }
                                retValue += padding(month, 2);
                                pattern = '';
                                break;
                            case 'M':
                                if (format.charAt(i + 1) == 'M') {
                                    break;
                                }
                                retValue += parseInt(month, 10);
                                pattern = '';
                                break;
                            case 'y':
                            case 'yyy':
                                if (format.charAt(i + 1) == 'y') {
                                    break;
                                }
                                retValue += pattern;
                                pattern = '';
                                break;
                            case 'yy':
                                if (format.charAt(i + 1) == 'y' && format.charAt(i + 2) == 'y') {
                                    break;
                                }
                                retValue += String(year).slice(-2);
                                pattern = '';
                                break;
                            case 'yyyy':
                                retValue += year;
                                pattern = '';
                                break;
                            case 'HH':
                                retValue += padding(time.hour, 2);
                                pattern = '';
                                break;
                            case 'H':
                                if (format.charAt(i + 1) == 'H') {
                                    break;
                                }
                                retValue += parseInt(time.hour, 10);
                                pattern = '';
                                break;
                            case 'hh':
                                /* time.hour is '00' as string == is used instead of === */
                                hour = (time.hour === 0 ? 12 : time.hour < 13 ? time.hour
                                        : time.hour - 12);
                                retValue += padding(hour, 2);
                                pattern = '';
                                break;
                            case 'h':
                                if (format.charAt(i + 1) === 'h') {
                                    break;
                                }
                                hour = (time.hour === 0 ? 12 : time.hour < 13 ? time.hour
                                        : time.hour - 12);
                                retValue += parseInt(hour, 10);
                                // Fixing issue https://github.com/phstc/jquery-dateFormat/issues/21
                                // retValue = parseInt(retValue, 10);
                                pattern = '';
                                break;
                            case 'mm':
                                retValue += padding(time.minute, 2);
                                pattern = '';
                                break;
                            case 'm':
                                if (format.charAt(i + 1) == 'm') {
                                    break;
                                }
                                retValue += time.minute;
                                pattern = '';
                                break;
                            case 'ss':
                                /* ensure only seconds are added to the return string */
                                retValue += padding(time.second.substring(0, 2), 2);
                                pattern = '';
                                break;
                            case 's':
                                if (format.charAt(i + 1) == 's') {
                                    break;
                                }
                                retValue += time.second;
                                pattern = '';
                                break;
                            case 'S':
                            case 'SS':
                                if (format.charAt(i + 1) == 'S') {
                                    break;
                                }
                                retValue += pattern;
                                pattern = '';
                                break;
                            case 'SSS':
                                retValue += time.millis.substring(0, 3);
                                pattern = '';
                                break;
                            case 'a':
                                retValue += time.hour >= 12 ? 'PM' : 'AM';
                                pattern = '';
                                break;
                            case 'p':
                                retValue += time.hour >= 12 ? 'p.m.' : 'a.m.';
                                pattern = '';
                                break;
                            case "'":
                                pattern = '';
                                inQuote = true;
                                break;
                            default:
                                retValue += currentPattern;
                                pattern = '';
                                break;
                        }
                    }
                    retValue += unparsedRest;
                    return retValue;
                } catch (e) {
                    return value;
                }
            },
            /*
             * JavaScript Pretty Date
             * Copyright (c) 2011 John Resig (ejohn.org)
             * Licensed under the MIT and GPL licenses.
             *
             * Takes an ISO time and returns a string representing how long ago the date
             * represents
             *
             * ('2008-01-28T20:24:17Z') // => '2 hours ago'
             * ('2008-01-27T22:24:17Z') // => 'Yesterday'
             * ('2008-01-26T22:24:17Z') // => '2 days ago'
             * ('2008-01-14T22:24:17Z') // => '2 weeks ago'
             * ('2007-12-15T22:24:17Z') // => 'more than 5 weeks ago'
             *
             */
            prettyDate: function (time) {
                var date;
                var diff;
                var day_diff;

                if (typeof time === 'string' || typeof time === 'number') {
                    date = new Date(time);
                }

                if (typeof time === 'object') {
                    date = new Date(time.toString());
                }

                diff = (((new Date()).getTime() - date.getTime()) / 1000);

                day_diff = Math.floor(diff / 86400);

                if (isNaN(day_diff) || day_diff < 0) {
                    return;
                }

                if (diff < 60) {
                    return 'just now';
                } else if (diff < 120) {
                    return '1 minute ago';
                } else if (diff < 3600) {
                    return Math.floor(diff / 60) + ' minutes ago';
                } else if (diff < 7200) {
                    return '1 hour ago';
                } else if (diff < 86400) {
                    return Math.floor(diff / 3600) + ' hours ago';
                } else if (day_diff === 1) {
                    return 'Yesterday';
                } else if (day_diff < 7) {
                    return day_diff + ' days ago';
                } else if (day_diff < 31) {
                    return Math.ceil(day_diff / 7) + ' weeks ago';
                } else if (day_diff >= 31) {
                    return 'more than 5 weeks ago';
                }
            },
            toBrowserTimeZone: function (value, format) {
                return this.date(new Date(value), format || 'MM/dd/yyyy HH:mm:ss');
            }
        };
    }());
}(jQuery));

jQuery.format.date.defaultShortDateFormat = 'dd/MM/yyyy';
jQuery.format.date.defaultLongDateFormat = 'dd/MM/yyyy HH:mm:ss';

jQuery(document).ready(function () {
    jQuery(".shortDateFormat").each(function (idx, elem) {
        if (jQuery(elem).is(":input")) {
            jQuery(elem).val(jQuery.format.date(jQuery(elem).val(), jQuery.format.date.defaultShortDateFormat));
        } else {
            jQuery(elem).text(jQuery.format.date(jQuery(elem).text(), jQuery.format.date.defaultShortDateFormat));
        }
    });
    jQuery(".longDateFormat").each(function (idx, elem) {
        if (jQuery(elem).is(":input")) {
            jQuery(elem).val(jQuery.format.date(jQuery(elem).val(), jQuery.format.date.defaultLongDateFormat));
        } else {
            jQuery(elem).text(jQuery.format.date(jQuery(elem).text(), jQuery.format.date.defaultLongDateFormat));
        }
    });
});
