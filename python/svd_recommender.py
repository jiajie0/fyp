import numpy as np
import pandas as pd
import json
import sys

def svd_recommend(player_id, interaction_file):
    """
    使用 SVD 为指定用户生成推荐。
    
    参数:
        player_id (str): 用户 ID。
        interaction_file (str): 用户-游戏交互数据的 CSV 文件路径。

    返回:
        list: 推荐的游戏 ID 列表。
    """
    # 读取交互数据
    print(f"Reading interaction data from {interaction_file}")
    df = pd.read_csv(interaction_file)
    print(f"Data loaded successfully. Number of records: {len(df)}")
    print(f"Sample data: \n{df.head()}")  # 打印前几行数据进行检查

    # 如果数据太少，直接返回空推荐
    if len(df) < 2:
        print("Not enough data to perform SVD. At least two players and two games are required.")
        return []

    # 创建用户-游戏矩阵 (PlayerID x GameID)
    user_game_matrix = df.pivot(index='PlayerID', columns='GameID', values='TotalPlayTime').fillna(0)
    
    # 确保矩阵的数据类型为浮动类型
    user_game_matrix = user_game_matrix.astype(float)
    print(f"User-Game matrix created. Shape: {user_game_matrix.shape}")

    # 提取用户和游戏 ID 列表
    player_ids = user_game_matrix.index.tolist()
    game_ids = user_game_matrix.columns.tolist()

    # 执行 SVD 分解
    print(f"Performing SVD...")
    from scipy.sparse.linalg import svds
    if user_game_matrix.shape[0] > 1 and user_game_matrix.shape[1] > 1:
        U, sigma, Vt = svds(user_game_matrix.values, k=2)  # k 是降维的阶数，可调整
        sigma = np.diag(sigma)
    else:
        print("Not enough data for SVD.")
        return []

    # 重建预测矩阵
    predicted_matrix = np.dot(np.dot(U, sigma), Vt)
    predicted_df = pd.DataFrame(predicted_matrix, index=player_ids, columns=game_ids)

    # 生成推荐
    if player_id in player_ids:
        # 获取指定用户的预测分数
        player_row = predicted_df.loc[player_id]
        # 排序并选择前 5 个推荐
        recommendations = player_row.sort_values(ascending=False).head(5).index.tolist()
        print(f"Recommendations for player {player_id}: {recommendations}")
    else:
        # 如果用户 ID 不存在，返回空推荐
        recommendations = []
        print(f"Player {player_id} not found in the data.")

    return recommendations


