backend default {
    .host = "127.0.0.1";
    .port = "80";
}

sub vcl_recv {
    if (req.url ~ "^/varnish") {
        unset req.http.cookie;
    } else {
        return(pass);
    }
}

sub vcl_fetch {
    if (req.url ~ "^/varnish") {
        set beresp.ttl = 5s;
    }
}
