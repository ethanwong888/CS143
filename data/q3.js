db.laureates.aggregate([
  // group by 'familyName' and create a 'counter' variable that keeps track of how many times each familyName appears
  {$group: {_id: "$familyName.en", counter: {$sum: 1}}},

  // where id is not NULL and counter >= 5 (familyName appears at least 5 times)
  {$match: {$and: [{ counter: { $gte: 5 }}, { _id: { $ne:null }}]}},
  
  // select the familyName(s) that match the requirements
  {$project: {"familyName": "$_id", _id: 0 }}
])
