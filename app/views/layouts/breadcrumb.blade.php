<div class="bread-nav">
<?php  
$pages = Array( 
	'home' => '首頁', 
	'projects' => '專題（遊戲）管理', 
	'reports' => '報告列表', 
	'report' => '週報告'
	);

$print = '導航欄 :: ';
switch( $thisPage )
{
	case 'home': 
		$print .= '<a href="/" class="active">'.$pages['home'].'</a>';
		break;
	case 'projects':
		$print .= '<a href="/">'.$pages['home'].'</a><a class="active">'.$pages['projects'].'</a>';
		break;
	case 'reports':
		$print .= '<a href="/">'.$pages['home'].'</a><a class="active">'.$pages['reports'].'</a>';
		break;
	case 'report':
		$print .= '<a href="/">'.$pages['home'].'</a><a class="active">'.$pages['report'].' '.$period.'</a>';
		break;
	default: 
		$print = '';
		break;
}
echo $print;
?>
</div>