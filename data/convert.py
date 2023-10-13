import json

# FIX THIS TO ACCOUNT FOR THE CORRECT DIRECTORY
data = json.load(open("/home/cs143/data/nobel-laureates.json", "r"))

# create file to write to
file1 = open('./laureates.import', 'w')

# loop through 'laureates' data and write it into the file
for x in data['laureates']:  
    file1.write(json.dumps(x))

file1.close()
