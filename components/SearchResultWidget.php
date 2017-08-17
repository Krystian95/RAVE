<?php

/**
 * Built with: http://silviomoreto.github.io/bootstrap-select/examples
 */
namespace app\components;

use yii\base\Widget;
use app\assets\SearchResultAsset;

class SearchResultWidget extends Widget {

    public $query;
    public $results;

    public function init() {
        parent::init();

        SearchResultAsset::register($this->getView());
    }

    public function run() {

        $results_count = sizeof($this->results);

        $html = <<<HTML
<h2 id="results-container-anchor" class="results-for">Results for "<span class="search-result-query">{$this->query}</span>"</h2><span class="marker"><input id="marker" type="checkbox"/> <label for="marker">Mark matches for searched text</label></span>
<table id="results-container">
<tbody class="list-group">
HTML;
        if ($results_count > 0) {
            foreach ($this->results as $result) {
                $html .= <<<HTML
        <tr>
            <td class="search-result" onclick="location.href='{$result['url']}';">
                <p class="search-result-title">
                    {$result['title']}
                </p>
HTML;
                if (isset($result['snippet'])) {
                    $html .= '<span class="search-result-snippet">' . $result['snippet'] . '</span>';
                }

                $html .= <<<HTML
            </td>
        </tr>
HTML;
            }
        } else {
            $html .= '<tr><td><p>Oops... No results was found. Please try to change the search key.</p></td></tr>';
        }

        $html .= <<<HTML
</tbody>
</table>
HTML;

        return $html;
    }

}
