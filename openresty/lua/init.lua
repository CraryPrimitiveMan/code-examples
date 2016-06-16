--初始化耗时的模块
local redis = require 'resty.redis'
local cjson = require 'cjson'

--全局变量，不推荐
if not count then
  count = 1
end

--共享全局内存
local shared_data = ngx.shared.shared_data
shared_data:set("count", 1)
--[[
if not shared_data:get("count") then
    shared_data:set("count", 1)
end
--]]
