import requests
import sys
import json
import re
import urllib.parse
from pprint import pprint


def get_next_links(start_page, link):
    answer = requests.get(start_page + link)
    if answer.status_code != requests.codes.ok:
       print("Fail")
       return None
    answer_text = answer.text.replace("\n", " ")
    # find /wiki/%D0%91%D0%B0%D1%81%D1%82%D1%8B
    template = r"/wiki/%[a-zA-Z\.0-9/%]+"
    links = re.findall(template, answer_text)
    # remove dublicate
    links = sorted(list(set(links)))
    return links


if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("python3 kk.py https://kk.wikipedia.org")
        exit(1)
    start_page = sys.argv[1]

    links_0 = [""]
    for link in links_0:
        links_1 = get_next_links(start_page, link)
        print("Level 1:")
        for link in links_1:
            print(urllib.parse.unquote(link))

