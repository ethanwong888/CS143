db.laureates.aggregate([
  // have to look in nobelPrizes -> orgName (matches the tuples that actually have an orgName using the 'exists' clause)
  {$unwind: "$nobelPrizes"},
  {$match: {"orgName": {$exists: true}}},

  // select and store the award year in the 'year' variable
  {$project: {"year": "$nobelPrizes.awardYear", _id: 0}},

  // group by year, and create a 'count' variable that keeps track of how many times each year appears
  {$group: { _id: "$year", count: {$sum: 1}}},
  // create a 'years' variable that keeps track of the number of different years
  {$group: {_id: null, years: {$sum: 1}}},
  // select the 'years' and return
  {$project: {_id: 0}}
])
