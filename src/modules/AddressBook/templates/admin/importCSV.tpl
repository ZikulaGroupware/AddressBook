{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="info" size="small"}
    <h3>{gt text="Import CSV"}</h3>
</div>

<p class="z-informationmsg">
    {gt text='Order:'} firstname, lastname, nickname, role, organisation, email, 
    phones, bday, participants, categories, approved<br />
    CSV: $delimiter = ',', $enclosure = '"', $escape = '\\'<br />
    dateformat: %d.%m.%Y (20.02.2011)
</p>


{form cssClass="z-form z-linear"}
    {formvalidationsummary}


    <fieldset>

        <div class="z-formrow">
            {formtextinput textMode="multiline" rows='4' cols='100' id="input" text='FirstName,LastName,NickName,Role,Organisation,1@1.com,1234,1.1.1900,Note'}
        </div>


    </fieldset>



    <div class="z-formbuttons z-buttons">
        {formbutton class="z-bt-preview" commandName="test" __text="Test"}
        {formbutton class="z-bt-archive" commandName="save" __text="Import"}
    </div>


{/form}



{if isset($test)}

<br /><br />
<table class="z-datatable">
    <thead>
    <tr>
        {foreach from=$cols item="col"}
        <th>{$col}</th>
        {/foreach}
    </tr>
    </thead>
    <tbody>
    {foreach from=$test item='task'}
    <tr class="{cycle values='z-odd,z-even'}">
        {foreach from=$cols item="col"}
        <td>{$task.$col}</td>
        {/foreach}
    </tr>
    {/foreach}
</tbody>
</table>
{/if}

{adminfooter}