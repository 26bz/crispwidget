@php
$crispId = $blueprint->dbGet('{identifier}', 'crispId');
@endphp

@if($crispId && !empty(trim($crispId)))
<script type="text/javascript">
    window.$crisp = [];
    window.CRISP_WEBSITE_ID = "{{ $crispId }}";
    (function() {
        d = document;
        s = d.createElement("script");
        s.src = "https://client.crisp.chat/l.js";
        s.async = 1;
        d.getElementsByTagName("head")[0].appendChild(s);
    })();
</script>
@endif