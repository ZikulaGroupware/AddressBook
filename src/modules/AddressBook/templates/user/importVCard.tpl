<h2> Import VCard</h2>

<form class="z-form" enctype="multipart/form-data" action="{modurl modname='AddressBook' func='importVCard'}" method="POST">


    <div class="z-formrow">
        <label>{gt text="Add a file to this section:"}</label>
        <input type="file" name="file" id="file" ></p>
    </div>


    <div class="z-center z-buttons">

        {button src='button_ok.gif' set='icons/extrasmall' __alt='Upload' __title='Upload' __text='Upload'}
        <a href="{modurl modname='AddressBook'}">
            {img modname='core' src='button_cancel.png' set='icons/extrasmall' __alt='Cancel' __title='Cancel'} {gt text='Cancel'}
        </a>
    </div>

</form>
