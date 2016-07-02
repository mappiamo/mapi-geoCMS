<?php

// no direct access to this file
defined( 'DACCESS' ) or die;

?>

<ul class="nav nav-pills nav-stacked">
		<li><a href="index.php?module=mcontent&task=content_list">Contents <span class="glyphicon glyphicon-list"></span></a></li>

    <?php if ( 2 >= MAuth::group_id() ): ?>
    <li><a href="index.php?module=mcategory&task=category_list">Categories <span class="glyphicon glyphicon-list-alt"></span></a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add <span class="caret"></span></a>
            <ul class="dropdown-menu">
                  <li><a href="index.php?module=mcontent&task=content_add">Add new content <span class="glyphicon glyphicon-plus"></span></a></li>
                  <li><a href="index.php?module=mcontent&task=content_import">Import content <span class="glyphicon glyphicon-import"></span></a></li>
                  <li><a href="index.php?module=mxmlimport&task=mxml_preview">Import content from XML<span class="glyphicon glyphicon-import"></span></a></li>
                  <li><a href="index.php?module=mgeojsonimport&task=mgeo_preview">SHP->GeoJson Importer<span class="glyphicon glyphicon-import"></span></a></li>
                  <li><a href="index.php?module=mdataimport&task=data_preview">Data importer<span class="glyphicon glyphicon-import"></span></a></li>
                  <li><a href="index.php?module=mphrcimport&task=mphrc_preview">PHRC importer<span class="glyphicon glyphicon-import"></span></a></li>
                  <li><a href="index.php?module=mcategory&task=category_add">Add new category <span class="glyphicon glyphicon-plus"></span></a></li>
            </ul>
        </li>

  		<li class="divider"></li>

    <?php endif; ?>
<?php if ( 2 >= MAuth::group_id() ): ?>

  		<li><a href="index.php?module=mpage&task=page_list">Pages <span class="glyphicon glyphicon-inbox"></span></a></li>
  		<li><a href="index.php?module=mmenu&task=menu_list">Menus <span class="glyphicon glyphicon-link"></span></a></li>
        <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Add <span class="caret"></span></a>
                <ul class="dropdown-menu">
                        <li><a href="index.php?module=mpage&task=page_add">Add a new page <span class="glyphicon glyphicon-plus"></span></a></li>
                        <li><a href="index.php?module=mmenu&task=menu_add">Add a new menu <span class="glyphicon glyphicon-plus"></span></a></li>
                </ul>
        </li>

      <li class="divider"></li>

<?php endif; ?>
<?php if ( 1 == MAuth::group_id() ): ?>

  		<li><a href="index.php?module=mmodule&task=module_list">Modules <span class="glyphicon glyphicon-hdd"></span></a></li>
      <li><a href="index.php?module=mtemplate&task=template_list">Templates <span class="glyphicon glyphicon-eye-open"></span></a></li>
  		<li><a href="index.php?module=mwidget&task=widget_list">Widgets <span class="glyphicon glyphicon-th-large"></span></a></li>

  		<li class="divider"></li>

  		<li><a href="index.php?module=muser&task=user_list">Users list <span class="glyphicon glyphicon-user"></span></a></li>
  		<li><a href="index.php?module=muser&task=user_add">Add new user <span class="glyphicon glyphicon-plus"></span></a></li>

  		<li class="divider"></li>

  		<li><a href="index.php?module=preferences">Preferences <span class="glyphicon glyphicon-cog"></span></a></li>

      <li class="divider"></li>

<?php endif; ?>

      <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php MPut::_html( MAuth::user() ); ?> <span class="caret"></span></a>
                <ul class="dropdown-menu">
                        <li>
                                <a href="index.php?module=profile">
                                        Profile <span class="glyphicon glyphicon-user"></span>
                                </a>
                        </li>
                        <li>
                                <a href="javascript:void(0)" onclick="$( '#logout-form' ).submit();">
                                        <form action="index.php?module=login" method="post" id="logout-form">
                                                <input type="hidden" name="do-logout" value="1" />
                                                Logout <span class="glyphicon glyphicon-off"></span>
                                        </form>
                                </a>
                        </li>
                </ul>
        </li>
</ul>
