<ul class="nav nav-pills">
<? if (!isset($menus) || empty($menus)) :
        $menus = $this->requestAction('/contents/menu');
    endif; 
    foreach($menus as $menu) : 
?>
    <li>
    <?="<a href='".DS.'content'.DS.$menu['Content']['sefURL']."'>".$menu['Content']['title']."</a>"; ?>
    </li>
<? endforeach; ?>
</ul>