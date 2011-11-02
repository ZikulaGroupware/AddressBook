
document.observe('dom:loaded', addressbook_init);



function addressbook_init()
{
    $('addressbook_phones_new_container').hide();
    $('addressbook_emails_new_container').hide();
}

function addressbook_hide()
{
    $('addressbook_phones_new_container').toggle();
}

function addressbook_emails_new()
{
    $('addressbook_emails_new_container').toggle();
}