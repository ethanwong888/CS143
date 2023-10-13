db.laureates.aggregate([
  // have to look in nobelPrizes -> affiliations -> name
  {$unwind: "$nobelPrizes"},
  {$unwind: "$nobelPrizes.affiliations"},
  {$match: {"nobelPrizes.affiliations.name.en": "University of California"}},

  // group by the affiliation's city and create a 'counter' variable that keeps track of how many times each city appears
  {$group: {_id: "$nobelPrizes.affiliations.city.en", counter: {$sum: 1}}},
  // create a 'locations' variable that keeps track of the number of distinct locations
  {$group: {_id: null, locations: {$sum: 1}}},
  // select the 'locations' and return
  {$project: {_id: 0}}
])
