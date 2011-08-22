{ajaxheader modname=AddressBook filename=addressbook.js noscriptaculous=true effects=true}
{form cssClass="z-form"}
{formvalidationsummary}

<fieldset>


    <div class="z-formrow">
        {formlabel for="firstname" __text="First name"}
        {formtextinput id="firstname" maxLength="64"}
    </div>


    <div class="z-formrow">
        {formlabel for="lastname" __text="Last name"}
        {formtextinput id="lastname" maxLength="64"}
    </div>

    <div class="z-formrow">
        {formlabel for="nickname" __text="Nick name"}
        {formtextinput id="nickname" maxLength="64"}
    </div>

    <div class="z-formrow">
        {formlabel for="note" __text="Note"}
        {formtextinput id="note" maxLength="64"}
    </div>

    <div class="z-formrow">
        {formlabel for="organisation" __text="Organisation"}
        {formtextinput id="organisation" maxLength="64"}
    </div>

    <div class="z-formrow">
        {formlabel for="categories" __text="Categories"}
        {formtextinput id="categories" maxLength="255"}
        <em class="z-formnote z-sub">{gt text="E.g. School,Friend"}</em>
    </div>

</fieldset>

<fieldset>
    <legend>{gt text='Emails'}</legend>

    {foreach item=item key=key from=$emails}
    <div class="z-formrow">
        {formlabel for="emails_$key" __text="E-Mail"}
        {formemailinput id="emails_$key" group='emails' text=$emails.$key}
    </div>
    {/foreach}

    <a class="z-icon-es-add" href="javascript:addressbook_emails_new()">Add more email addresses</a>
    <div id="addressbook_emails_new_container">
        <div class="z-formrow">
            {formlabel}
            {formemailinput id="email_new1"}
        </div>
        <div class="z-formrow">
            {formlabel}
            {formemailinput id="email_new2"}
        </div>
    </div>


</fieldset>
<fieldset>
    <legend>{gt text='Phones'}</legend>

    {foreach item=item key=key from=$phones}
    <div class="z-formrow">
        {formlabel}
        <div>
            {formdropdownlist id="pt_$key" group='phones_types' items=$phone_types selectedValue=$phones.$key.t} 
            {formtextinput id="pn_$key" group='phones_numbers' maxLength="64" text=$phones.$key.n}
        </div>
    </div>
    {/foreach}

    <a class="z-icon-es-add" href="javascript:addressbook_hide()">Add more phone numbers</a>
    <div id="addressbook_phones_new_container">
        <div class="z-formrow">
            {formlabel}
            <div>
                {formdropdownlist id="phone_new1_type"   items=$phone_types} 
                {formtextinput    id="phone_new1_number" maxLength="64"}
            </div>
        </div>
        <div class="z-formrow">
            {formlabel}
            <div>
                {formdropdownlist id="phone_new2_type"   items=$phone_types selectedValue="Work"} 
                {formtextinput    id="phone_new2_number" maxLength="64"}
            </div>
        </div>
    </div>

</fieldset>
<fieldset>


    <div class="z-formrow">
        {formlabel for="role" __text="Role"}
        {formtextinput id="role" maxLength="64"}
    </div>

    <div class="z-formbuttons z-buttons">
        {formbutton class="z-bt-ok" commandName="save" __text="Save"}
        {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
    </div>


</fieldset>

{/form}
