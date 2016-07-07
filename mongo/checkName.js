# 获取前n名推荐人中存在较多名字不正确的人的列表
var count = 200, collectionName='test', data = [];
var qrcodes = db.screferralMemberTempQrcode
    .find({"campaignId" : "575d2fe8905e88123d8b45a5"})
    .sort({"shareCount": -1})
    .limit(count);
db.getCollection(collectionName).drop();
for(var i=0; i<qrcodes.length(); i++) {
    var logs = db.screferralShareLog.find({
        "shareUser.nickname":/^([0-9]+|[a-z]{4,6})$/,
        "user.member.id":qrcodes[i].user.memberId
    });
    if (logs.length() < 5) {
        continue;
    }
    for(var j=0; j<logs.length(); j++) {
        data.push({
            logId: logs[j]._id.str,
            introducerId: logs[j].user.member.id.str,
            introducerName: logs[j].user.nickname,
            referralId: logs[j].shareUser.member.id.str,
            referralName: logs[j].shareUser.nickname,
            //referralTime: logs[j].createdAt,
            referralTime: logs[j].createdAt.getFullYear()+ '-' +
                          logs[j].createdAt.getUTCMonth()+ '-' +
                          logs[j].createdAt.getDate() + ' ' +
                          logs[j].createdAt.getHours() + ':' +
                          logs[j].createdAt.getMinutes()+ ':'+
                          logs[j].createdAt.getSeconds(),
            status: logs[j].status === 'share success' ? '有效': '无效'
        });
    }
}
db.getCollection(collectionName).insert(data);

# 获取用户名不对的推荐
db.user.find({
    "unsubscribeTime" : {
        "$gte":ISODate("2016-06-23T16:00:00.000Z"),
        "$lte":ISODate("2016-06-24T16:00:00.000Z")
    }, "$or":[
        {
            "tags": "Introducer"
        },
        {
            "tags": "Referral"
        }
    ], "nickname":/^([0-9]+|[a-z]{4,6})$/
});

var data = [];
var a = 0;
for(var i = 0; i<users.length(); i++) {
    var logs = db.couponLog.find({"member.id":users[i]._id, "status":"redeemed"});
    if (logs.length() > 1) {
        data.push(logs.length());
    }
    data.push(logs.length());
}
data


# 获取campaign奖励分段之间的时间间距
var indexes = [1, 5, 10, 50, 100];
var users = db.screferralMemberTempQrcode.find({"shareCount": {"$gte":5}});
var data = [];
for (var i=0; i<users.length(); i++) {
    var userId = users[i].user.memberId;
    var beforeLog = null;
    var item = {"memberId":userId.valueOf()};
    for (var j=0; j<5; j++) {
        var log = db.screferralShareLog.find({
            "status" : "share success",
            "user.member.id": userId
        }).sort({"createdAt":1}).skip(indexes[j] - 1).limit(1);
        if (log[0]) {
            log = log[0];
            if (beforeLog && beforeLog.createdAt) {
                item["" + indexes[j - 1] + "-" + indexes[j]] = (log.createdAt - beforeLog.createdAt)/1000;
            } else if (log && log.user) {
                item["name"] = log.user.nickname
            }
            beforeLog = log;
        }
        item["totalAll"] = db.screferralShareLog.count({"user.member.id": userId});
        item["totalValid"] = users[i].shareCount;
    }
    data.push(item);
}
db.test1.insert(data)

// mongoexport -d wmtest -c test -f logId,introducerId,introducerName,referralId,referralName,referralTime,status -o /home/user/Desktop/test111.csv
// db.screferralShareLog.find({"user.member.id":ObjectId("576bcc86fa2f94134c8b7694")}, {"shareUser.member.name":1})



var shareLogs = db.screferralShareLog.aggregate(
    [
      {
        $group : {
           _id : {
             memberId : "$user.member.id"
           },
           shareUsers : { $push: "$shareUser.member.id" }
        }
      }
  ]
);


# 获取A推荐B，B推荐A的情况
var used = {};
var data = [];
//shareLogs.result.length
for (var i = 0; i < shareLogs.result.length; i++) {
    var introducerId = shareLogs.result[i]._id.memberId;
    var referrerIds = shareLogs.result[i].shareUsers;
    for (var j = 0; j < referrerIds.length; j++) {
        var referrerId = referrerIds[j];
        var key1 = introducerId.valueOf() + referrerId.valueOf();
        var key2 = referrerId.valueOf() + introducerId.valueOf();

        if (used[key1] || used[key2]) {
            continue;
        }
        var introducerLog = db.screferralShareLog.find({
            "user.member.id" : introducerId,
            "shareUser.member.id" : referrerId
        }).sort({ "createdAt" : 1 }).limit(1);
        introducerLog = introducerLog[0];

        var item = {
            "introducerId" : introducerId.valueOf(),
            "introducerName" : introducerLog.user.nickname,
            "referrerId" : referrerId.valueOf(),
            "referrerName" : introducerLog.shareUser.nickname,
            "A-B" : introducerLog.createdAt.getFullYear()+ '-' +
                  introducerLog.createdAt.getUTCMonth()+ '-' +
                  introducerLog.createdAt.getDate() + ' ' +
                  introducerLog.createdAt.getHours() + ':' +
                  introducerLog.createdAt.getMinutes()+ ':'+
                  introducerLog.createdAt.getSeconds(),
            "A-B-status": introducerLog.status === "share success" ? "有效" : "无效",
        };
        var referrerLog = db.screferralShareLog.find({
            "user.member.id" : referrerId,
            "shareUser.member.id" : introducerId
        }).sort({ "createdAt" : 1 }).limit(1);
        if (referrerLog && referrerLog[0]) {
            referrerLog = referrerLog[0];
            item["B-A"] = referrerLog.createdAt.getFullYear()+ '-' +
                  referrerLog.createdAt.getUTCMonth()+ '-' +
                  referrerLog.createdAt.getDate() + ' ' +
                  referrerLog.createdAt.getHours() + ':' +
                  referrerLog.createdAt.getMinutes()+ ':'+
                  referrerLog.createdAt.getSeconds();
            item["B-A-status"] = referrerLog.status === "share success" ? "有效" : "无效";
        }
        data.push(item)
        used[key1] = true;
    }
}
db.test2.insert(data)
