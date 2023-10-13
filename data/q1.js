db.laureates.find(
    {"knownName.en": "Marie Curie"}, {"id": 1, _id: 0}
)

// _id: 0 is to suppress the id from showing
