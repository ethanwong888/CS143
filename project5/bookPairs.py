from pyspark import SparkContext
from itertools import combinations

sc = SparkContext("local", "BookPairs")

# create the BookPairs in the format of (bookid_1, bookid_2)
def createBookPairs(line):
    # finding where the colon is (user1:book1,book2,...,bookn)
    for i in range(len(line)):
      temp = line[i]
      if temp == ":":
        break
    # create list of books based on whats after the ':', delimiter is ',' 
    book = line[i+1:].split(',')
    # create all possible pairings of books
    bookpairs = combinations(book, 2)
    # create a list of tuples that shows the bookpairs in correct format (bookid_1, bookid_2)
    finalpairs = [(int(bp[0]), int(bp[1])) for bp in bookpairs]
    return finalpairs

# read the text file with the book data
lines = sc.textFile("/home/cs143/data/goodreads.user.books")
# generate the pairs and separate them into single books?
pairs = lines.flatMap(lambda x: createBookPairs(x))
# match each single book with a 1
pairsOne = pairs.map(lambda y: (y, 1))
# use reduceByKey to count the amount of times that the single book appears in reviews
pairsReduced = pairsOne.reduceByKey(lambda x, y: x + y)
# filter out the pairs so that only ones with count >= 21 remain
pairsFiltered = pairsReduced.filter(lambda x: x[1] >= 21)
# save results into a text file
pairsFiltered.saveAsTextFile("output")
