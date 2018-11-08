import praw
import sys
import json

reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')



def REDDIT_TITLE_GRAB():


	COMMENT_TALLY = {}
	#payload = []
	mark = 0


	#seachquest = raw_input("what are you looking for?")#askes the user for a topic
	seachquest = str(sys.argv[2])

	#[limit] is the amount of reasults it will return
	for submission in reddit.subreddit('all').search(seachquest,limit=200):
		try: 
			#starts to tally the comments that people make
			print(submission.title.encode('utf-8').strip())
			TITLE_ID = submission.id
			POST = reddit.submission(id=TITLE_ID)

			POST.comment_limit = 0
			POST.comments.replace_more(limit=0)

			#Goes though a title to see how many times someone posted
			for comment in POST.comments.list():
				if comment.author in COMMENT_TALLY:
					COMMENT_TALLY[comment.author] += 1
				else:
					COMMENT_TALLY[comment.author] = 1
		except :
			continue
		
				
	for user in sorted(COMMENT_TALLY, key=COMMENT_TALLY.get, reverse=True):
		mark+=1
		#payload.append(str(user) +';'+ str(COMMENT_TALLY[user]))
		print(str(user) +';'+ str(COMMENT_TALLY[user]))
		if mark == int(sys.argv[1]): break
	
REDDIT_TITLE_GRAB()
