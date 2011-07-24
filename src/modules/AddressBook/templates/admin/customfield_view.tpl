<!--[* $Id: addressbook_admin_customfield_view.html 68 2010-04-01 13:07:05Z herr.vorragend $ *]-->
<!--[pnajaxheader modname="AddressBook" filename="addressbook.js"]-->
<!--[insert name='generateauthkey' module='AddressBook' assign="authid"]-->

<!--[include file="addressbook_admin_menu.htm"]-->
<div class="z-admincontainer">
    <!--[gt text="Custom fields" assign="templatetitle"]-->
    <div class="z-adminpageicon"><!--[pnimg modname='core' src='windowlist.gif' set='icons/large' alt=$templatetitle]--></div>
    <h2><!--[$templatetitle]--></h2>
    <p class="z-informationmsg"><!--[gt text='You can change the order of the fields with drag and drop.']--></p>
    <p><a id="addnewitem" title="<!--[gt text="Add new custom field"]-->" href="<!--[pnmodurl modname="AddressBook" type="admin" func="edit" ot="customfield"]-->"><!--[gt text="Add new custom field"]--></a></p>
    <ol id="cf_list" class="z-itemlist">
        <li id="cf_list_header" class="z-itemheader z-clearfix">
            <span class="z-itemcell z-w05"><!--[gt text="ID"]--></span>
            <span class="z-itemcell z-w40"><!--[gt text="Custom field"]--></span>
            <span class="z-itemcell z-w40"><!--[gt text="Data Type"]--></span>
            <span class="z-itemcell z-w10"><!--[gt text="Action"]--></span>
        </li>
        <!--[foreach from=$objectArray item=obj]-->
        <li id="cfitem_<!--[$obj.id|pnvarprepfordisplay]-->" class="<!--[cycle values="z-odd,z-even"]--> z-sortable z-clearfix">
            <div class="z-clearfix">
                <span class="z-itemcell z-w05"><!--[$obj.id|pnvarprepfordisplay]--></span>
                <span class="z-itemcell z-w40"><!--[$obj.name|pnvarprepfordisplay]--></span>
                <span class="z-itemcell z-w40"><!--[$obj.type|customtype]--></span>
                <span class="z-itemcell z-w10">
                    <!--[securityutil_checkpermission component='AddressBook::' instance='::' level='ACCESS_ADMIN' assign='adminAuth']-->
                    <!--[if ($adminAuth)]-->
                    <a href="<!--[pnmodurl modname="AddressBook" type="admin" func="edit" ot="customfield" id=$obj.id]-->"><!--[pnimg modname=core src=xedit.png set=icons/extrasmall __alt="Edit" __title="Edit"]--></a>
                    <!--[if $obj.id > 4]-->
                    <a href="<!--[pnmodurl modname="AddressBook" type="admin" func="delete" ot="customfield" id=$obj.id authid=$authid]-->"><!--[pnimg src='14_layer_deletelayer.gif' modname='core' set='icons/extrasmall' __alt="Delete" __title="Delete"]--></a>
                    <!--[/if]-->
                    <!--[/if]-->
                </span>
            </div>
        </li>
        <!--[/foreach]-->
    </ol>
    <script type="text/javascript">
        Event.observe(window, 'load', function(){customfieldinit();}, false);
    </script>

</div>