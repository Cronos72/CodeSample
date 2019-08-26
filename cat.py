# Work with Python 3.6
import discord, requests, json
import random as generator


url = "https://catfact.ninja/facts?limit=500"
cat_fact_json_data = []
TOKEN = ''
facts = ["Cats are one of, if not the most, popular pet in the world.",
      "Cats and humans have been associated for nearly 10000 years.",
      "Cats can be lethal hunters and very sneaky, when they walk their back paws step almost exactly in the same place as the front paws did beforehand, this keeps noise to a minimum and limits visible tracks",
      "Cats have powerful night vision, allowing them to see at light levels six times lower than what a human needs in order to see.",
      "Cats spend a large amount of time licking their coats to keep them clean"
         ]
      
a= 0
b = 4
    
class MyClient(discord.Client):
    async def on_ready(self):
        print('Logged on as', self.user)
        

    async def on_message(self, message):
        # don't respond to ourselves
        if message.author == self.user:
            return

        #if message.content == 'ping':
        if message.content == "!catfacts" :
            await message.channel.send(cat_fact_json_data['data'][generator.randint(0,cat_fact_count)]['fact'])

        if message.content == '!catnip' :
            out = ""
            for i in range(generator.randint(0,25)):
                 out = "meow " * generator.randint(0,15)
            await message.channel.send(out)

        if message.content == '!members':
            ul = self.users
            for i in ul:
                try:
                    print(i)
                    await message.channel.send(i)
                except UnicodeEncodeError:
                    print("Unicode error")
                    await message.channel.send("Unicode error")


r = requests.get(url)
cat_fact_json_data = json.loads(r.text)
cat_fact_count = len(cat_fact_json_data['data'])
#cat_fact_json_data['data'][0]['fact'] // this will return a fact

client = MyClient()

client.run(TOKEN)
