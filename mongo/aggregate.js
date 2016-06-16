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
