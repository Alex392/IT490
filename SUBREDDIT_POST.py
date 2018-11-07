import praw
import sys
import json

#this code will make a post on a subreddit

reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')

print(reddit.user.me())

def SUBREDDIT_POST():

	SUBREDDIT = sys.argv[1]	
	TITLE = sys.argv[2]
	POST = sys.argv[3]
	
	
	
	#POST = reddit.submission(id=IDSearch)#makes Post a submission object. can now use submission comands/functions on POST

	reddit.subreddit(str(SUBREDDIT)).submit(str(TITLE), selftext=str(POST))
	#print('You posted :: ' + str(POST))
	#print('On ' + str(SUBREDDIT))

SUBREDDIT_POST()
