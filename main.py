from pdf2image import convert_from_path
from glob import glob
from mysql.connector import connect
from PIL import Image
import os


db_config = {
    'user': 'root',
    'password': '',
    'host': 'localhost',
    'database': 'csc'
}

cnx = connect(**db_config)
cur = cnx.cursor()

for file in glob('**/*.pdf'):
    basename = os.path.basename(file)
    print(basename)
    pdf = "./pdf/{0}".format(basename)
    thumbnail = "./thumbnail/{0}.jpg".format(basename)
    sql = """INSERT INTO pdf(link,thumbnail) values (%s,%s)"""
    cur.execute(sql, (pdf, thumbnail))
    cnx.commit()
