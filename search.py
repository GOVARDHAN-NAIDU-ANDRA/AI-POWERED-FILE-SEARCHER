import mysql.connector
from sklearn.feature_extraction.text import TfidfVectorizer

def search_files(query):
    # Connect to MySQL
    conn = mysql.connector.connect(host="localhost", user="root", password="", database="file_search")
    cursor = conn.cursor(dictionary=True)

    # Fetch all files and content
    cursor.execute("SELECT id, filename, filepath, content FROM files")
    files = cursor.fetchall()
    
    if not files:
        return []

    # Extract text for TF-IDF
    texts = [file["content"] for file in files]
    vectorizer = TfidfVectorizer()
    tfidf_matrix = vectorizer.fit_transform(texts)
    query_vector = vectorizer.transform([query])

    scores = (tfidf_matrix * query_vector.T).toarray()
    ranked_files = sorted(zip(files, scores), key=lambda x: x[1], reverse=True)

    return [{"filename": f["filename"], "filepath": f["filepath"]} for f, s in ranked_files if s > 0]

# Example Usage:
# print(search_files("machine learning"))
