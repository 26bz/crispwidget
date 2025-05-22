@php
$provider = $blueprint->dbGet('{identifier}', 'provider');
$widgetId = $blueprint->dbGet('{identifier}', 'widgetId');
$baseUrl = $blueprint->dbGet('{identifier}', 'baseUrl') ?: 'https://app.chatwoot.com';
@endphp

@if($provider && $provider !== 'disabled' && $widgetId && !empty(trim($widgetId)))
@switch($provider)
@case('crisp')
<script type="text/javascript">
  window.$crisp = [];
  window.CRISP_WEBSITE_ID = "{{ $widgetId }}";
  (function() {
    d = document;
    s = d.createElement("script");
    s.src = "https://client.crisp.chat/l.js";
    s.async = 1;
    d.getElementsByTagName("head")[0].appendChild(s);
  })();
</script>
@break

@case('livechat')
<script>
  window.__lc = window.__lc || {};
  window.__lc.license = {
    {
      $widgetId
    }
  };
  window.__lc.integration_name = "manual_onboarding";
  window.__lc.product_name = "livechat";;
  (function(n, t, c) {
    function i(n) {
      return e._h ? e._h.apply(null, n) : e._q.push(n)
    }
    var e = {
      _q: [],
      _h: null,
      _v: "2.0",
      on: function() {
        i(["on", c.call(arguments)])
      },
      once: function() {
        i(["once", c.call(arguments)])
      },
      off: function() {
        i(["off", c.call(arguments)])
      },
      get: function() {
        if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
        return i(["get", c.call(arguments)])
      },
      call: function() {
        i(["call", c.call(arguments)])
      },
      init: function() {
        var n = t.createElement("script");
        n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
      }
    };
    !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
  }(window, document, [].slice))
</script>
<noscript><a href="https://www.livechat.com/chat-with/{{ $widgetId }}/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechat.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
@break

@case('chatwoot')
<script>
  (function(d, t) {
    var BASE_URL = "{{ rtrim($baseUrl, '/') }}";
    var g = d.createElement(t),
      s = d.getElementsByTagName(t)[0];
    g.src = BASE_URL + "/packs/js/sdk.js";
    g.defer = true;
    g.async = true;
    s.parentNode.insertBefore(g, s);
    g.onload = function() {
      window.chatwootSDK.run({
        websiteToken: '{{ $widgetId }}',
        baseUrl: BASE_URL
      })
    }
  })(document, "script");
</script>
@break

@case('tawk')
<script type="text/javascript">
  var Tawk_API = Tawk_API || {},
    Tawk_LoadStart = new Date();
  (function() {
    var s1 = document.createElement("script"),
      s0 = document.getElementsByTagName("script")[0];
    s1.async = true;
    s1.src = 'https://embed.tawk.to/{{ $widgetId }}';
    s1.charset = 'UTF-8';
    s1.setAttribute('crossorigin', '*');
    s0.parentNode.insertBefore(s1, s0);
  })();
</script>
@break

@case('tidio')
<script src="//code.tidio.co/{{ $widgetId }}.js" async></script>
@break

@case('zendesk')
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key={{ $widgetId }}"></script>
@break

@case('zoho')
<script>
  window.$zoho = window.$zoho || {};
  $zoho.salesiq = $zoho.salesiq || {
    ready: function() {}
  };
</script>
<script id="zsiqscript" src="https://salesiq.zohopublic.com/widget?wc={{ $widgetId }}" defer></script>
@break
@endswitch
@endif