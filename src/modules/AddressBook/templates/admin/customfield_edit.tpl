<!--[* $Id: addressbook_admin_customfield_edit.html 68 2010-04-01 13:07:05Z herr.vorragend $ *]-->
<!--[pnajaxheader modname="AddressBook" filename="addressbook.js"]-->
<!--[include file="addressbook_admin_menu.htm"]-->
<div class="z-admincontainer">
    <!--[if ($customfield.id)]-->
    <div class="z-adminpageicon"><!--[pnimg modname='core' src='xedit.png' set='icons/large' alt=$templatetitle]--></div>
    <!--[else]-->
    <div class="z-adminpageicon"><!--[pnimg modname='core' src='filenew.gif' set='icons/large' alt=$templatetitle]--></div>
    <!--[/if]-->
    <h2><!--[gt text="Custom fields"]--></h2>

    <form class="z-form" action="<!--[pnmodurl modname="AddressBook" type="adminform" func="edit"]-->" method="post" enctype="application/x-www-form-urlencoded">
        <div>
            <!--[if ($customfield.id)]-->
            <input id="customfield_id" name="customfield[id]" value="<!--[$customfield.id|pnvarprepfordisplay]-->" type="hidden" />
            <!--[/if]-->
            <input type="hidden" name="authid" value="<!--[insert name='generateauthkey' module='AddressBook']-->" />
            <input type="hidden" name="ot" value="customfield" />
            <!--[if ($customfield.id)]-->
            <input type="hidden" id="customfield_position" name="customfield[position]" value="<!--[$customfield.position|pnvarprepfordisplay]-->" />
            <!--[else]-->
            <input type="hidden" id="customfield_position" name="customfield[position]" value="<!--[$new_position|pnvarprepfordisplay]-->" />
            <!--[/if]-->
            <fieldset>
                <!--[if ($customfield.id)]-->
                <legend><!--[gt text="Edit field"]--></legend>
                <!--[else]-->
                <legend><!--[gt text="Add field"]--></legend>
                <!--[/if]-->
                <div class="z-formrow">
                    <label for="customfield_name"><!--[gt text="Field name"]--></label>
                    <input id="customfield_name" name="customfield[name]" value="<!--[$customfield.name|pnvarprepfordisplay]-->" type="text" size="60" maxlength="80" />
                </div>
                <div class="z-formrow">
                    <!--[ab_getdatatypes assign="ab_datatype"]-->
                    <label for="customfield_type"><!--[gt text="Data Type"]--></label>
                    <select id="customfield_type" name="customfield[type]" onchange="toggleoption();">
                        <!--[foreach from=$ab_datatype item=data]-->
                        <option value="<!--[$data.type|pnvarprepfordisplay]-->" <!--[if $data.type==$customfield.type]-->selected="selected"<!--[/if]-->><!--[$data.dspname|pnvarprepfordisplay]--></option>
                        <!--[/foreach]-->
                    </select>
                </div>
                <div id="custom_option" style="display:none;">
                    <div class="z-formrow">
                        <label for="customfield_option"><!--[gt text="Items (comma-separated values)"]--></label>
                        <textarea id="customfield_option" name="customfield[option]" cols="40" rows="4"><!--[$customfield.option|pnvarprepfordisplay]--></textarea>
                    </div>
                </div>
            </fieldset>
            <div class="z-formbuttons">
                <!--[pnbutton src='button_ok.gif' set='icons/small' __alt="Create" __title="Create"]-->
                <a href="<!--[pnmodurl modname=AddressBook type=admin func=view ot=customfield]-->"><!--[pnimg modname='core' src='button_cancel.png' set='icons/small'   __alt="Cancel" __title="Cancel"]--></a>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        Event.observe(window, 'load', dropdown_check_init, false);

        function dropdown_check_init()
        {
            Event.observe('customfield_type', 'change', dropdown_onchange, false);
            if ( $('customfield_type').value == "dropdown") {
                $('custom_option').show();
            }
        }

        function dropdown_onchange()
        {
            if ( $('customfield_type').value == "dropdown") {
                Effect.BlindDown('custom_option');
            } else {
                Effect.BlindUp('custom_option');
            }
        }
    </script>
</div>