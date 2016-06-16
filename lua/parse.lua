file = io.open("conf","r")

local t = {}
local currentName = ""

for line in file:lines() do
  for name in string.gmatch(line, "%[(%w+)%]") do
    currentName = name
    t[name] = {}
  end
end

file:close()
