import praw
import time
import sys
import json

#this is the code that will retrive a Redditor's USER INFORMATION
#Such as: USERNAME; REDDIT ID; DATE THE ACCOUNT WAS CREATED;E-MAIL VERIFICATION



reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
	             client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
	             username = 'nullbreakers-1',
	             password ='DJKehoe',
	             user_agent ='testapp')
#print(reddit.user.me())


def USER_INFO():
#userSearch = raw_input("Who are you looking for?")#askes the user who they are looking for
	#print(sys.argv)
	userSearch = str(sys.argv[1])
	try:
		USERNAME = reddit.redditor(name=userSearch).name
		REDDIT_ID = reddit.redditor(name=userSearch).id
		rB_DAY = time.strftime("%Y-%m-%d",time.localtime(reddit.redditor(name=userSearch).created_utc))
		EMAIL = reddit.redditor(name=userSearch).has_verified_email
				

	except :
		USERNAME = 'NULL'
		REDDIT_ID = 'NULL'
		rB_DAY = 'NULL'
		EMAIL = 'NULL'
	
	#Commented out to make it easier for the front end
	print(USERNAME)
	print(REDDIT_ID)
	print(rB_DAY)
	print(str(EMAIL))

	payload = [USERNAME, REDDIT_ID, rB_DAY, str(EMAIL)]
	
	#print(payload)
	#print(json.dumps(payload))
	#return json.dumps(payload)
	#return USERNAME
	#return REDDIT_ID
	#return rB_DAY
	#return EMAIL
USER_INFO()
