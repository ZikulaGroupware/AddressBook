<a id="r_{$id}">
    {img modname=core set=icons/extrasmall src='14_layer_deletelayer.png' alt='Remove'}
</a>
<script type="text/javascript">
    reloadIt = function() {
        window.location.href=window.location.href;
    }

    deleteIt = function(res) {
        if(res) {
            var pars = "module={{$module}}&func={{$func}}&id={{$id}}";
            var myAjax = new Ajax.Request(
                "ajax.php",
                {
                    method: 'get',
                    parameters: pars,
                    onComplete: reloadIt
                });
        }
    }
    $('r_{{$id}}').observe(
        'click',
        Zikula.UI.IfConfirmed(
            'Do you want to remove this entry?',
            'Confirm action',
            deleteIt
        )
    );
</script>