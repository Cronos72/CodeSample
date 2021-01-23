### Programm to connect to the University of Calgary's LIBRARIES
### AND CULTURAL RESOURCES api and retrieve "Alberta Gazette 1908" .
### The website https://cdm22007.contentdm.oclc.org/digital/collection/p22007coll9/id/492409/rec/2
### Does this via a fetch request which can be viewed in the developer tools network tab.
### This program emulates this behavior. It makes a request to the api which returns a json object
### Which needs is then unicode encoded and writen toa file called book txt.
### The following improvements are needed:
#   Error handling in case the server fails to respond. (atm just rerun program)
import requests,json, time

#Original URL for reference
#url = "https://cdm22007.contentdm.oclc.org/digital/api/collections/p22007coll9/items/491899/false"


page_count = 512;

url_prefix = "https://cdm22007.contentdm.oclc.org/digital/api/collections/p22007coll9/items/"
url_page_count = 491899;
url_suffix = "/false"

urls = []
url =""


#Construct a list of urls that will serve as a work queue
for i in range(page_count):
    # construct a url from the prefix, incremented page counter and suffix
    #and store it in the list of urls
    url = url_prefix+ str(url_page_count+1)+url_suffix
    urls.append(url)
    url_page_count += 1

f= open("book.txt","w+" ,  encoding="utf-8") #Not specifying the encoding causes some errors

for j in range(len(urls)):
    print(j)

    if j% 50 == 0: #Delay to give server time to process and inorder to not exceed request limit
        time.sleep(7)
        
    r = requests.get(url = urls[j])
    json_data = json.loads(r.text) 
    # save the page number, url and text in file
    
    f.write("Page #"+ str(j) +"\n")
    f.write("URL :" + urls[j]+"\n")
   
    f.write(json_data['text'])
    #page divider
    #https://www.asciiart.eu/art-and-design/dividers
    f.write("\n\n\n\n\n")
    f.write("^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^v^")
    f.write("\n\n\n\n\n") 

   
    
f.close()
print("done")




