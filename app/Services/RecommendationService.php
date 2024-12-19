<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MathPHP\LinearAlgebra\MatrixFactory;

class RecommendationService
{
    public function recommendGamesForPlayer($playerID, $topN = 5)
    {
        // Step 1: 获取用户的游戏类别
        $playerGames = DB::table('game_store')
            ->where('PlayerID', $playerID)
            ->join('games', 'game_store.GameID', '=', 'games.GameID')
            ->pluck('games.GameCategory')
            ->toArray();

        if (empty($playerGames)) {
            return []; // 如果玩家没有游戏记录，返回空推荐
        }

        // 将 GameCategory 转换为独热编码格式
        $categories = ['Action', 'Role-Playing Game', 'Strategy', 'Sports & Racing', 'Adventure', 'Casual & Puzzle', 'Multiplayer Online','Experimental'];
        $playerVector = $this->encodeCategories($playerGames, $categories);

        // Step 2: 构建用户-游戏矩阵
        $matrix = $this->buildUserGameMatrix($categories);

        // Step 3: 使用 MathPHP 实现 SVD
        $svd = $this->computeSVD($matrix);

        // Step 4: 根据玩家的特征向量生成推荐
        $recommendations = $this->generateRecommendations($svd, $playerVector, $categories, $topN);

        return $recommendations;
    }

    private function encodeCategories($gameCategories, $allCategories)
    {
        $encoded = array_fill(0, count($allCategories), 0);
        foreach ($gameCategories as $gameCategory) {
            $categories = json_decode($gameCategory, true);
            foreach ($categories as $category) {
                $index = array_search($category, $allCategories);
                if ($index !== false) {
                    $encoded[$index] = 1;
                }
            }
        }
        return $encoded;
    }

    private function buildUserGameMatrix($categories)
    {
        $allPlayers = DB::table('game_store')->distinct()->pluck('PlayerID')->toArray();
        $allGames = DB::table('games')->get(['GameID', 'GameCategory']);

        // 构建矩阵
        $matrix = [];
        foreach ($allPlayers as $player) {
            $matrixRow = array_fill(0, count($categories), 0);

            $playerGames = DB::table('game_store')
                ->where('PlayerID', $player)
                ->join('games', 'game_store.GameID', '=', 'games.GameID')
                ->pluck('games.GameCategory')
                ->toArray();

            foreach ($playerGames as $gameCategory) {
                $encoded = $this->encodeCategories([$gameCategory], $categories);
                $matrixRow = array_map(fn($x, $y) => $x + $y, $matrixRow, $encoded);
            }
            $matrix[] = $matrixRow;
        }

        return $matrix;
    }

    private function computeSVD(array $matrix)
    {
        // 使用 MathPHP 创建矩阵并进行 SVD 分解
        $matrix = MatrixFactory::create($matrix);
        $svd = $matrix->svd();

        return [
            'U' => $svd->getU()->getMatrix(),
            'Sigma' => $svd->getS()->getMatrix(),
            'V' => $svd->getV()->getMatrix(),
        ];
    }

    private function generateRecommendations($svd, $playerVector, $categories, $topN)
    {
        $V = $svd['V'];

        $predictedScores = [];
        foreach ($V as $gameIndex => $gameVector) {
            $score = 0;
            foreach ($playerVector as $i => $value) {
                $score += $value * $gameVector[$i];
            }
            $predictedScores[$categories[$gameIndex]] = $score;
        }

        arsort($predictedScores); // 按分数排序
        return array_slice(array_keys($predictedScores), 0, $topN);
    }
}
