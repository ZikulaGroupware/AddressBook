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

    <div class="z-formrow">
        {formlabel for="email" __text="E-Mail"}
        {formtextinput id="email" maxLength="64"}
    </div>

    <div class="z-formrow">
        {formlabel for="phone_home" __text="Phone"}
        {formtextinput id="phone_home" maxLength="64"}
    </div>

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
