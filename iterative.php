<?php //php 7.2.24

/* Вывести дерево без рекурсии в следующем виде
1
1.2
1.2.5
1.2.6
1.2.6.8
1.3
1.3.7
1.4
*/

$tree = [
    ['id' => '8', 'parent_id' => '6',],
    ['id' => '2', 'parent_id' => '1',],
    ['id' => '3', 'parent_id' => '1',],
    ['id' => '4', 'parent_id' => '1',],
    ['id' => '5', 'parent_id' => '2',],
    ['id' => '1', 'parent_id' => '0',],
    ['id' => '6', 'parent_id' => '2',],
    ['id' => '7', 'parent_id' => '3',],
];

$indexes = [];
//Проход для создания индексов, в финальный массив не попадут поддеревья, у которых отсутствует 0 в предках
foreach ($tree as $node) {
    $indexes[$node['id']] = ['id' => $node['id'], 'parent_id' => $node['parent_id'], 'children' => []];
}
//Не поддерживаются циклические структуры
foreach ($indexes as $index => $currentNode) {
    //Используем ссылки чтобы можно было работать с элементами в глубине дерева, поэтому не удаляем их из первого уровня
    $indexes[$currentNode['parent_id']]['children'][$index] = &$indexes[$index];
}

$treeStack = [$indexes[0]['children']];

while (count($treeStack)) {
    $current = array_shift($treeStack[count($treeStack)-1]);
    $treeStack[] = $current['children'];//Стек для определения глубины
    $line[] = $current['id'];//Стек для текущей строки
    echo implode('.', $line)."\n";
    while (count($treeStack) && count($treeStack[count($treeStack)-1]) == 0) {
        array_pop($treeStack);
        array_pop($line);
    }
}
