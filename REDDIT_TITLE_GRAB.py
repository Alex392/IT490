import praw
import sys
import json

reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')

print(reddit.user.me())

def REDDIT_TITLE_GRAB():


	COMMENT_TALLY = {}
	payload = []
	count = 1
	mark = 0


	#seachquest = raw_input("what are you looking for?")#askes the user for a topic
	seachquest = str(sys.argv[2])

	print(20*'=')
	#[limit] is the amount of reasults it will return
	for submission in reddit.subreddit('all').search(seachquest,limit=1000):
	#ask the user if they what to continue after every five
	#the defalt limit is 100
	#making the limit 1000 the titles stoped at around 250
		try: 
			print(str(count)+') User: {} Title ID: {}  Num_Comments: {} Score: {} Title: {} Link:  https://www.reddit.com{}'.format(submission.author,submission.id,submission.num_comments,submission.score,submission.title.encode('utf-8').strip(),submission.permalink))
			print(20*'=')
			USERNAME = submission.author
			TITLE_ID = submission.id
			TITLE = submission.title.encode('utf-8').strip()
		except :
			continue
		count+= 1
		#while count%5 == 0:
		#	YN_ANSWER = raw_input('Would you like to continue? (Y/N)')
		#	if YN_ANSWER == 'Y': break
		#	elif YN_ANSWER =='N': quit()
		#	else: continue
			
		
		

		#starts to tally the comments that people make
		POST = reddit.submission(id=TITLE_ID)

		POST.comment_limit = 0
		POST.comments.replace_more(limit=0)

		#Goes though a title to see how many times someone posted
		for comment in POST.comments.list():
			if comment.author in COMMENT_TALLY:
				COMMENT_TALLY[comment.author] += 1
			else:
				COMMENT_TALLY[comment.author] = 1
		

		if count == (int(sys.argv[1])+1): break
	print("we made it")


	for user in sorted(COMMENT_TALLY, key=COMMENT_TALLY.get, reverse=True):
		mark+=1
		payload.append(str(user) +';'+ str(COMMENT_TALLY[user]))
		if mark == 20: break
	print('PYTHON')
	print(20*'=')
	print(payload)
	print('JSON')
	print(20*'=')
	print(json.dumps(payload))
	return json.dumps(payload)
REDDIT_TITLE_GRAB()
