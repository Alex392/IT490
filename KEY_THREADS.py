import praw
import sys
import json
import matplotlib.pyplot as plt
import numpy as np

reddit = praw.Reddit(client_id = 'pPciqPn--wkB9Q' ,
                     client_secret = 'pX5mKEZUUP2QP7w4bux1haeBDuc' ,
                     username = 'nullbreakers-1',
                     password ='DJKehoe',
                     user_agent ='testapp')



def KEY_THREADS():


	
	count = 1
	#sys.argv[2] is the topic
	seachquest = str(sys.argv[2])
	LINK_payload = []
	COMMENTNUM_payload = []

	
	#sys.argv[1] is the amount of posts that we will see
	num = int(sys.argv[1])
	for submission in reddit.subreddit('all').search(seachquest,limit=num):
		try: 
			print('https://www.reddit.com{}'.format(submission.permalink))
			LINK_payload.append('Link# '+str(count))
			COMMENTNUM_payload.append(submission.num_comments)
			
		except :
			continue
		count+= 1
		
	
	#here is where the graph is made
	plt.figure(1,figsize=(16,16))
	LINK_count = np.arange(len(LINK_payload))
	plt.gcf().subplots_adjust(bottom=0.30)
	plt.style.use('ggplot')
	plt.title(seachquest , fontsize = 15 , fontweight = 'bold')
	plt.xlabel('Submissions' , fontsize = 12 , fontweight = 'bold')
	plt.ylabel('Number of comments' , fontsize = 13 , fontweight = 'bold')
	plt.bar(LINK_payload, COMMENTNUM_payload)
	
	plt.xticks(LINK_count, LINK_payload, fontsize=20, fontweight='bold', rotation=-90, multialignment='left')
	plt.yticks(fontsize=12, fontweight='semibold')
	
	#plt.show()

	plt.savefig('payload', dpi=None, facecolor='w', edgecolor='b', orientation='portrait', papertype=None, format='png', transparent=False, bbox_inches=None, pad_inches=0.1, frameon=None, metadata=None)
	#upload.py starts as soon as it is imported
	import upload	
		
KEY_THREADS()
