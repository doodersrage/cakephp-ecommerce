<? 
if (!isset($menus) || empty($menus)) {
        $menus = $this->requestAction('/contents/menu');
	}; 
	
	echo '<ul class="nav nav-pills">';
	foreach($menus as $idx => $mItm){
		
		if(isset($mItm['Content'])){
			// gather link information
			if($mItm['Content']['sefURL']){
				$urlLnk = $mItm['Content']['sefURL'];
			} else {
				$urlLnk = $mItm['Content']['id'];
			}
			echo '<li><a href="'.DS.'pages'.DS.$urlLnk.'">'.$mItm['Content']['title'].'</a>';
				child_check($idx,$menus);
			echo '</li>';
		}
	}
	echo '</ul>';
	
	function child_check($idx,$menus){
		if(isset($menus[$idx]['children'])){

			echo '<ul>';
			foreach($menus[$idx]['children'] as $mItm){
				
				// gather link information
				if($mItm['Content']['sefURL']){
					$urlLnk = $mItm['Content']['sefURL'];
				} else {
					$urlLnk = $mItm['Content']['id'];
				}
				
				echo '<li><a href="'.DS.'pages'.DS.$urlLnk.'">'.$mItm['Content']['title'].'</a>';
					child_check($mItm['Content']['id'],$menus);
				echo '</li>';
			}
			echo '</ul>';
		}
	}

