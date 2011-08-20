{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="config" size="small"}
    <h3>{gt text="Modify configuration"}</h3>
</div>

{form cssClass="z-form"}
{formvalidationsummary}

<fieldset>
    <legend>{gt text="General settings"}</legend>


    <div class="z-formrow">
        {formlabel for="preferences_itemsperpage" __text="Contacts per page"}
        {formintinput id="preferences_itemsperpage" size="4" maxLength="4"}
    </div>

    <div class="z-formrow">
        {formlabel for="preferences_globalprotect" __text="Disable personal address book mode"}
        {formcheckbox id="globalprotect"}
    </div>
</fieldset>
<fieldset>

    <legend>{gt __text="Google Maps integration"}</legend>

    <div class="z-formrow">
        {formlabel for="preferences_google_api_key" __text="Google API key"}
        {formtextinput id="preferences_google_api_key" size="90" maxLength="120"}
    </div>

    <div class="z-formrow">
        {formlabel for="preferences_google_zoom" __text="Google zoom"}
        {formtextinput id="preferences_google_zoom" size="4" maxLength="2"}
    </div>

</fieldset>

<div class="z-formbuttons z-buttons">
      {formbutton class="z-bt-ok" commandName="save" __text="Save"}
      {formbutton class="z-bt-cancel" commandName="cancel" __text="Cancel"}
</div>
{/form}

{adminfooter}