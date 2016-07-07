db.screferralShareLog.aggregate([
{
  '$match': {
    'id': ObjectId('xxxxxxxx'),
    'isDeleted': false,
    'status': 'success',
    'createdAt': {
      '$gte':ISODate("2016-06-14T16:00:00.000Z"),
      '$lt':ISODate("2016-06-15T16:00:00.000Z")
    }
  }
},
{
  '$group': {
    '_id': "distint_key",
    'total' : { '$sum': 1 }
  }
},
{
  '$sort': { 'total': -1 }
},
{ '$limit' : 5 }
]);

db.user.aggregate(
   [
      {
          $match: {
              "unsubscribeTime" : {
                "$gte":ISODate("2016-06-23T16:00:00.000Z"),
                "$lte":ISODate("2016-06-24T16:00:00.000Z")
              }
          }
      },
      {
        $group : {
           _id : {
             year: { $year: "$unsubscribeTime" },
             month: { $month: "$unsubscribeTime" },
             day: { $dayOfMonth: "$unsubscribeTime" },
             hour: { $hour: "$unsubscribeTime" }
           },
           count: { $sum: 1 }
        }
      },
      {
          $project : { _id: -1, count: 1, hour: { $mod: [ { $add: [ "$_id.hour", 8 ] }, 24] } }
      },
      {
          $sort : { count : -1 }
      }
   ]
)
