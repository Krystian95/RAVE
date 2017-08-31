<?php

namespace app\components;

use yii\base\Widget;
use app\assets\CrossrefAsset;

/*
 * Widget that draws the Crossref result (via d3.js).
 * It has one public property $crossref (the crossref results).
 */
class CrossrefWidget extends Widget {

    /*
     * The crossref results.
     */
    public $crossref;

    public function init() {
        parent::init();

        CrossrefAsset::register($this->getView());
    }

    public function run() {

        $html = '';

        $crossref = $this->crossref;

        $html .= '<div class="crossref-results">';

        if (sizeof($crossref) > 0) {

            foreach ($crossref as $result) {

                $html .= '<div class="result">';

                if (isset($result['title'])) {

                    $title_element = '<span class="title">';

                    if (isset($result['link'])) {
                        $title_element .= '<a class="link external" href="' . $result['link'] . '">';
                    }

                    $title_element .= $result['title'];

                    if (isset($result['link'])) {
                        $title_element .= '</a>';
                    }

                    $title_element .= '</span>';
                    if (isset($result['link_corrupted'])) {
                        $title_element .= '<div class="corrupted-link" title="The link will generate a Page Not Found Error"></div>';
                    }
                    $html .= $title_element;
                }

                if (isset($result['authors'])) {

                    if (sizeof($result['authors']) > 0) {

                        $authors = '<br><span class="authors-label">Author(s)</span>:';

                        foreach ($result['authors'] as $author) {

                            if (isset($author['given'])) {
                                $authors .= '<span class="author-given">' . $author['given'] . '</span>';
                            }

                            if (isset($author['family'])) {
                                $authors .= ' <span class="author-family">' . $author['family'] . '</span>';
                            }

                            if (isset($author['affiliation'])) {
                                if (sizeof($author['affiliation']) > 0) {

                                    $authors .= ' (<span class="author-affiliations">';

                                    $affiliations = '';

                                    foreach ($author['affiliation'] as $affiliation) {

                                        if (isset($affiliation['name'])) {
                                            $affiliations .= $affiliation['name'] . ', ';
                                        }
                                    }

                                    $authors .= substr($affiliations, 0, -2) . '</span>)';
                                }
                            }

                            $authors .= ', ';
                        }

                        $html .= substr($authors, 0, -2);
                    }
                }

                if (isset($result['date_time'])) {
                    $html .= '<br><span class="date_time-label">Created at</span>: <span class="date_time">' . $result['date_time'] . '</span>';
                }

                if (isset($result['ISBN'])) {
                    $html .= '<br><span class="ISBN-label">ISBN</span>: <span class="ISBN">' . $result['ISBN'] . '</span>';
                }

                if (isset($result['link'])) {
                    $html .= '<a href="' . $result['link'] . '" target="_blank"><div class="right_arrow"></div></a>';
                }

                $html .= '</div>';
            }
        } else {
            $html .= '<h4 class="no-posts">Oops... No <span class="crossref-color">Crossref</span>result was found.</h4>';
        }

        $html .= '</div>';

        return $html;
    }

}
