if ngx.req.get_uri_args()["jump"] == "1" then
   ngx.req.set_uri("/lua_rewrite_3", false);
   ngx.req.set_uri("/lua_rewrite_4", false);
   ngx.req.set_uri_args({a = 1, b = 2});
end
