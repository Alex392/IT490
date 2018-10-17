import praw

reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')

print(reddit.user.me())

count = 0

#for some reason ($ . ?) give errors

seachquest = raw_input("what are you looking for?")#askes the user for a topic

#[limit] is the amount of reasults it will return
for submission in reddit.subreddit('all').search(seachquest,limit=3):
	count+= 1
	print(str(count)+')Title: {},user: {}'.format(submission.title.encode('utf-8').strip(),submission.author)


#prints out the comments
	
#	submission.comments.replace_more(limit=0)

#	for comment in submission.comments.list():
#		print(20*'-')
#		print('User: ' , comment.author)#{comment.author} gives the user name
#		print('Parent ID:', comment.parent())
#		print('Comment ID:', comment.id)
#		print(comment.body)

print('-------------------')

#the code from here on down is following this video
# https://www.youtube.com/watch?v=NRgfgtzIhBQ

subreddit = reddit.subreddit('python')

hot_python = subreddit.hot(limit=5)

for submission in hot_python:
    print('Title: {}, ups: {}, downs: {}, Have we visted: {}'.format(submission.title,
                                                                     submission.ups,
                                                                     submission.downs,
                                                                     submission.visited))
#    submission.comments.replace_more(limit=0)

#    for comment in submission.comments.list():
#        print(20*'-')
#        print('Parent ID:', comment.parent())
#	print('Comment ID:', comment.id)
#	print(comment.body)


