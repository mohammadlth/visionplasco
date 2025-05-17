<form action="https://bpm.shaparak.ir/pgwchannel/startpay.mellat" method="POST">
    <input type="hidden" id="RefId" name="RefId" value="{{$refId}}">
</form>

<script type="text/javascript">
    window.onload = formSubmit;

    function formSubmit() {
        document.forms[0].submit();
    }
</script>
