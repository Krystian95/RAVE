<?php

namespace app\components;

use yii\base\Widget;
use app\assets\PostListAsset;

class PostListWidget extends Widget {

    public $category;
    public $posts;

    public function init() {
        parent::init();

        PostListAsset::register($this->getView());
    }

    public function run() {

        $post_count = sizeof($this->posts);

        $html = <<<HTML
<h1 class="post-list-title">{$this->category}</h1>
<div class="post-list-container">
HTML;
        if ($post_count > 0) {
            foreach ($this->posts as $post) {

                if ($post['newer']) {
                    $newer = '<span data-id="' . $post['id'] . '" class="label label-default updated">' . $post['newer'] . '</span>';
                } else {
                    $newer = '';
                }

                $html .= <<<HTML
                    <div class="col-md-3 post-container"><a href="{$post['url']}"><h3 data-id="{$post['id']}" data-title="{$post['title']}" class="post"><div data-id="{$post['id']}" class="flag"></div> {$post['title']} {$newer}</h3></a></div>
HTML;
            }
        } else {
            $html .= '<h2 class="no-posts">Oops... No results was found. Please try to change the search key.</h2>';
        }

        $html .= <<<HTML
</div>
HTML;

        return $html;
    }

}
