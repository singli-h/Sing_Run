from flask import Flask, jsonify, request
import numpy as np

app = Flask(__name__)

@app.route('/')
def hello():
    return jsonify({"message": "Hello, World!"})

@app.route('/average', methods=['POST'])
def calculate_average():
    data = request.json.get('data', [])
    
    if not data:
        return jsonify({"error": "Data not provided!"}), 400
    
    avg = np.mean(data)
    return jsonify({"average": avg})

if __name__ == "__main__":
    app.run(debug=True)
