db.laureates.aggregate([
  // have to look in nobelPrizes -> affiliations -> name (look where name == CERN)
  {$unwind: "$nobelPrizes"},
  {$unwind: "$nobelPrizes.affiliations"},
  {$match: {"nobelPrizes.affiliations.name.en": "CERN"}},

  // based on these, choose the 'nobelPrizes.affiliations.country.en'
  {$project: {"country": "$nobelPrizes.affiliations.country.en", _id: 0}}, 
  
  // limit it to one result returned, don't want duplicates
  {$limit: 1}]
)



