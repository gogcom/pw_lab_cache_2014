backend default {
    .host = "127.0.0.1";
    .port = "80";
}

sub vcl_recv {
    if (req.url ~ "^/varnish") {
        unset req.http.cookie;
    } elseif (req.url ~ "^/esi_include") {
        unset req.http.cookie;
    } elseif (req.url ~ "^/esi$") {
        set req.http.Surrogate-Capability = "ESI/1.0";
    } else {
        return(pass);
    }
}

sub vcl_fetch {
    if (req.url ~ "^/varnish") {
        unset beresp.http.set-cookie;
        set beresp.ttl = 5s;
    }
    if (req.url ~ "^/esi_include") {
        set beresp.ttl = 10s;
    }

    if (req.url ~ "^/esi") {
        set beresp.do_esi = true;
        set beresp.ttl = 5s;
    }
}
