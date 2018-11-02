import praw
import time
import sys

#this is the code that will retrive a Redditor's USER INFORMATION
#Such as: USERNAME; REDDIT ID; DATE THE ACCOUNT WAS CREATED;E-MAIL VERIFICATION


reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')

print(reddit.user.me())


userSearch = raw_input("Who are you looking for?")#askes the user who they are looking for
try:

	USERNAME = reddit.redditor(name=userSearch).name
	REDDIT_ID = reddit.redditor(name=userSearch).id
	rB_DAY = time.strftime("%Y-%m-%d",time.localtime(reddit.redditor(name=userSearch).created_utc))
	EMAIL = reddit.redditor(name=userSearch).has_verified_email
		

except :
	print('the account is avable')
	sys.exit()


print('USERNAME: ' + USERNAME)
print('REDDIT_ID: ' + REDDIT_ID)
print('rB_DAY: ' + rB_DAY)
print('EMAIL: ' + str(EMAIL))
