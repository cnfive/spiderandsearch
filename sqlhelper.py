from utils import POOL
import pymysql


def create_conn():
  conn = POOL.connection()
  # cursor = conn.cursor(pymysql.cursors.DictCursor)
  cursor = conn.cursor()
  return conn, cursor


def close_conn(conn, cursor):
  conn.close()
  cursor.close()


def select_one(sql, args):
  conn, cur = create_conn()
  try:
    cur.execute(sql, args)
    result = cur.fetchone()
    close_conn(conn, cur)
    return result
  except Exception as e:
    print("select one except ", args)
    close_conn(conn, cur)
    return None


def select_all(sql, args):
  conn, cur = create_conn()
  try:
    cur.execute(sql, args)
    result = cur.fetchall()
    close_conn(conn, cur)
    return result
  except Exception as e:
    print("select all except ", args)
    close_conn(conn, cur)
    return None


def insert_one(sql, args):
  conn, cur = create_conn()
  try:
    result = cur.execute(sql, args)
    conn.commit()
    close_conn(conn, cur)
    return True
  except Exception as e:
    print("insert except ", args)
    conn.rollback()
    close_conn(conn, cur)
    return False


def delete_one(sql, args):
  conn, cur = create_conn()
  try:
    result = cur.execute(sql, args)
    conn.commit()
    close_conn(conn, cur)
    return True
  except Exception as e:
    print("delete except ", args)
    conn.rollback()
    close_conn(conn, cur)
    return False

def update_one(sql, args):
  conn, cur = create_conn()
  try:
    result = cur.execute(sql, args)
    conn.commit()
    close_conn(conn, cur)
    return True
  except Exception as e:
    print("update except ", args)
    conn.rollback()
    return False

# sql = "insert into stu(id,name,age) VALUE (%s,%s,%s)"   #增加
# res = insert_one(sql, [2,"飞机", 28])
# print(res)

# sql = "delete from stu where name = %s"   #删除
# res = delete_one(sql, "哪吒")
# print(res)

# sql = "select * from stu"   #查询全部
# res = select_all(sql, [])
# print(res)

# sql = "select * from stu where name=%s"   #查询一条
# res = select_one(sql, "赵振伟")
# print(res)