<h2>
    <a href="{modurl modname="AddressBook" type='user' func='main'}">
        {gt text="Address Book"}
    </a>
</h2><br />

{pageaddvar name='javascript' value='javascript/helpers/Zikula.UI.js'}
 

{form cssClass="z-form"}
{formvalidationsummary}

<fieldset>

    {formlabel for="name" __text="Name"}
    {formtextinput id="name" maxLength="50" style="border-style:solid;border-width:1px;"}

    {formtextinput textMode="hidden" id="letter" maxLength="1"}


    {formlabel for="organisation" __text="Organisation"}
    {formdropdownlist id="organisation" items=$organisations style="border-style:solid;border-width:1px;"}

    {*formlabel for="category" __text="Category"*}
    {*formdropdownlist id="category" items=$categories class="z-formcolumn" style="border-style:solid;border-width:1px;"*}

    {formbutton commandName="save" __text="Search" style="border-style:solid;border-width:1px;"}

</fieldset>


<!-- <div id="addressbook-alphafilter" class="z-center">
    <strong>[ {*pagerabc posvar="letter" forwardvars="name,organisation,category" printempty=true*} ] [ <a href="{modurl modname='AddressBook' type='user' func='modify'}"> {gt text='New entry'}</a>]</strong>
</div> --!>


{/form}


<table class="z-datatable">
    <thead>
        <tr>

            <th>{gt text="Name"}</th>
            <th>{gt text="Organisation"}</th>
            <th>{gt text="Phone"}</th>
            <th>{gt text="E-Mail"}</th>
            <th>{gt text="Categories"}</th>
            <th>{gt text="Action"}</th>
        </tr>
    </thead>
    <tbody>
        {foreach item=address from=$addresses}
        <tr class="{cycle values="z-odd,z-even"}">
            <td>
                
                <a id="defwindowminmax_{$address.pid}" href="#defwindow_content_minmax_{$address.pid}" title="{$address.firstname} {$address.lastname}">
                    {$address.title|safehtml} {$address.firstname|safehtml} {$address.lastname|safehtml}
                </a>



                <div id="defwindow_content_minmax_{$address.pid}" style="display:none;">
                    <table cellpadding=5 class="z-datatable">
                       <tr class="z-odd">
                            <td>{gt text="Nick name"}:</td>
                            <td>{$address.nickname}</td>
                       </tr>
                       <tr class="z-even">
                            <td>{gt text="Birthday"}:</td>
                            <td>{$address.bday}</td>
                       </tr>
                       <tr class="z-odd">
                            <td>{gt text="Homepage"}:</td>
                            <td>{$address.homepage}</td>
                       </tr>
                        <tr class="z-even">
                            <td>{gt text="Phone"}:</td>
                            <td>
                                {foreach from=$address.phones item="phone"}
                                {$phone.t|safehtml}: {$phone.n|safehtml}<br />
                                {/foreach}
                            </td>
                        </tr>
                       <tr class="z-odd">
                            <td>{gt text="E-Mail"}:</td>
                            <td>
                                {foreach from=$address.emails item="email"}
                                <a href="mailto:{$email|safehtml}">{$email|safehtml}</a><br />
                                {/foreach}
                            </td>
                       </tr>
                       <tr class="z-even">
                            <td>{gt text="Organisation"}:</td>
                            <td>{$address.organisation}</td>
                        </tr>
                       <tr class="z-odd">
                            <td>{gt text="Role"}:</td>
                            <td>{$address.role}</td>
                        </tr>
                       <tr  class="z-even">
                            <td>{gt text="Note"}:</td>
                            <td>{$address.note}</td>
                        </tr>
                    </table>
                </div>

                <script type="text/javascript">
                    var defwindowminmax = new Zikula.UI.Window(
                        $('defwindowminmax_{{$address.pid}}'),
                        {minmax:true,resizable: true}
                    );
                </script>


            </td>
            <td>{$address.organisation|safehtml}</td>
            <td>
                {foreach from=$address.phones item="phone"}
                {$phone.t|safehtml}: {$phone.n|safehtml}<br />
                {/foreach}
            </td>
            <td>
                {foreach from=$address.emails item="email"}
                <a href="mailto:{$email|safehtml}">{$email|safehtml}</a><br />
                {/foreach}
            </td>
            <td>
                {*foreach from=$address.categories item=category name=categories*} 
                    {*$category|safehtml}{if not $smarty.foreach.categories.last*}, {*/if*} 
                {*/foreach*}
            </td>
            <td class="z-nowrap">


                <a href="{modurl modname=AddressBook type=user func=modify pid=$address.pid}">
                    {img modname='core' set='icons/extrasmall' src="xedit.png" __alt="Edit" __title="Edit"}
                </a>


                {remove id=$address.pid}

            </td>
        </tr>


        {foreachelse}
        <tr class="z-datatableempty"><td colspan="6">{gt text="No address found."}</td></tr>
        {/foreach}
    </tbody>
</table>

<script type="text/javascript">
    Zikula.UI.Tooltips($$('.tooltips2'));
</script>