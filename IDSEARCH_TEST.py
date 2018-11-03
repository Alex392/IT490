import praw
import sys
import json

reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')

print(reddit.user.me())

def IDSEARCH_TEST():
	#IDSearch = raw_input("What is the id for the post you are looking for?")#askes the user for the post id
	
	IDSearch = sys.argv[1]
	
	POST = reddit.submission(id=IDSearch)#makes Post a submission object. can now use submission comands/functions on POST

	payload = POST.title.encode('utf-8').strip()
	print(payload)
	print(json.dumps(payload))
	return json.dumps(payload)

IDSEARCH_TEST()



