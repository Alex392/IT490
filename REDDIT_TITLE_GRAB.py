import praw

reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')

print(reddit.user.me())

count = 0


seachquest = raw_input("what are you looking for?")#askes the user for a topic

print(20*'=')
#[limit] is the amount of reasults it will return
for submission in reddit.subreddit('all').search(seachquest,limit=1000):
#ask the user if they what to continue after every five
#the defalt limit is 100
#making the limit 1000 the titles stoped at around 250
	count+= 1
	while count%5 == 0:
		YN_ANSWER = raw_input('Would you like to continue? (Y/N)')
		if YN_ANSWER == 'Y': break
		elif YN_ANSWER =='N': quit()
		else: continue
		
	print(str(count)+') User: {} Title ID: {}  Num_Comments: {} Score: {} Title: {} Post: {}'.format(submission.author,submission.id,submission.num_comments,submission.score,submission.title.encode('utf-8').strip(),submission.selftext))
	print(20*'=')
	USERNAME = submission.author
	TITLE_ID = submission.id
	TITLE = submission.title.encode('utf-8').strip()

