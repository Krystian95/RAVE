<?php

namespace app\components;

use yii\base\Widget;
use app\assets\HomeAsset;

class PostListWidget extends Widget {

    public $category;
    public $posts;

    public function init() {
        parent::init();

        HomeAsset::register($this->getView());
    }

    public function run() {

        $post_count = sizeof($this->posts);

        $html = <<<HTML
                
<h2 class="post-list-title">
    <img class="onu" src="css/images/onu.png" alt="United Nations flag"> 
    {$this->category}
</h2>

<p>
   The United Nations (UN) is an intergovernmental organization tasked to promote international co-operation and to create and 
   maintain international order. A replacement for the ineffective League of Nations, the organization was established on 24 
   October 1945 after World War II in order to prevent another such conflict. At its founding, the UN had 51 member states; there
   are now 193. The headquarters of the UN is in Manhattan, New York City, and is subject to extraterritoriality. Further main 
   offices are situated in Geneva, Nairobi, and Vienna. The organization is financed by assessed and voluntary contributions 
   from its member states. Its objectives include maintaining international peace and security, promoting human rights, fostering 
   social and economic development, protecting the environment, and providing humanitarian aid in cases of famine, natural disaster, 
   and armed conflict. The UN is the largest, most familiar, most internationally represented and most powerful intergovernmental 
   organization in the world.
</p>

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
