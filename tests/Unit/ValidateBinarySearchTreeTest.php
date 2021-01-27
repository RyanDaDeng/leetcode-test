<?php

namespace Tests\Unit;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class ValidateBinarySearchTreeTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {

    }

    /**
     * @param TreeNode $root
     * @return Boolean
     */
    function isValidBST($root)
    {

        return $this->isBST($root, pow(-2, 31), pow(2, 31) - 1);
    }

    function isBST($node, $min, $max)
    {
        if ($node == null) {
            return true;
        }
        if ($node->val > $max || $node->val < $min) {
            return false;
        }

        return ($this->isBST($node->left, $min, $node->val - 1) && $this->isBST($node->right, $node->val + 1, $max));
    }

}
