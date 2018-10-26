import praw
import time


reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')

print(reddit.user.me())


userSearch = raw_input("Who are you looking for?")#askes the user who they are looking for
try:
	if reddit.redditor(name=userSearch).has_verified_email:
		print('the user exists')
		print(reddit.redditor(name=userSearch).name)
		print(reddit.redditor(name=userSearch).id)
		print(time.strftime("%Y-%m-%d",time.localtime(reddit.redditor(name=userSearch).created_utc)))
		print(reddit.redditor(name=userSearch).has_verified_email)
	else: 
		print('You need varify your e-mail')
		print(reddit.redditor(name=userSearch).name)
		print(reddit.redditor(name=userSearch).id)
		print(time.strftime("%Y-%m-%d",time.localtime(reddit.redditor(name=userSearch).created_utc)))
		print(reddit.redditor(name=userSearch).has_verified_email)
except :
	print('the account is avable')
#	print(reddit.redditor(name=userSearch).name)
#	print(reddit.redditor(name=userSearch).id)
#	print(reddit.redditor(name=userSearch).created_utc)
#	print(reddit.redditor(name=userSearch).has_verified_email)



