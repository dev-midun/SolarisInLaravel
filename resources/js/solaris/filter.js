class Condition {

    /**
     * @param {string} logical
     * @param {string} leftCondition
     * @param {string} comparison
     * @param {any} rigthCondition
     */
    constructor(logical, leftCondition, comparison, rigthCondition) {
        this.logical = logical
        this.comparison = comparison
        this.conditions = {
            left: leftCondition,
            right: rigthCondition ?? null
        }
    }
}

class Group {
    groups = []

    /**
     * @param {string} logical default is logical AND
     */
    constructor(logical = Filter.LogicalType.AND) {
        this.logical = logical
    }

    /**
     * add condition to groups
     * @param {Condition|Group} condition
     * @returns {Group}
     */
    add(condition) {
        if(!(condition instanceof Condition) && !(condition instanceof Group)) {
            throw new Error("Condition is not valid")
        }

        this.groups.push(condition)
        return this
    }
}

export default class Filter {
    #filters = []

    static LogicalType = {
        AND: 'AND',
        OR: 'OR'
    }

    static ComparisonType = {
        Equal: 'EQUAL',
        NotEqual: 'NOT_EQUAL',
        Greater: 'GREATER',
        GreaterOrEqual: 'GREATER_OR_EQUAL',
        Less: 'LESS',
        LessOrEqual: 'LESS_OR_EQUAL',
        Contains: 'LIKE',
        StartWith: 'LIKE_START_WITH',
        EndWith: 'LIKE_END_WITH',
        In: 'IN',
        Between: 'BETWEEN',
        IsNull: 'IS_NULL',
        IsNotNull: 'IS_NOT_NULL'
    }

    /**
     * add and condition filter
     * @param {...string} args Group
     * @param {...string} args left, right
     * @param {...string} args left, comparison, right
     * @returns {Filter}
     */
    and(...args) {
        if(args.length == 0 || args.length > 3) {
            throw new Error("Parameter is not valid")
        }

        if(args.length == 1 && !(args[0] instanceof Group)) {
            throw new Error("Parameter is not valid")
        }

        if(args.length == 1) {
            this.#filters.push(args[0])
            return
        }

        return args.length == 2 ?
            this.add(Filter.LogicalType.AND, args[0], Filter.ComparisonType.Equal, args[1]) :
            this.add(Filter.LogicalType.AND, args[0], args[1], args[2])
    }

    /**
     * add and between condition filter
     * @param {string} left
     * @param {Array} right
     * @returns {Filter}
     */
    andBetween(left, right) {
        return this.add(Filter.LogicalType.AND, left, Filter.ComparisonType.Between, right)
    }

    /**
     * add and in condition filter
     * @param {string} left
     * @param {Array} right
     * @returns {Filter}
     */
    andIn(left, right) {
        return this.add(Filter.LogicalType.AND, left, Filter.ComparisonType.In, right)
    }

    /**
     * add and is null condition filter
     * @param {string} left
     * @returns {Filter}
     */
    andNull(left) {
        return this.add(Filter.LogicalType.AND, left, Filter.ComparisonType.IsNull)
    }

    /**
     * add and is not null condition filter
     * @param {string} left
     * @returns {Filter}
     */
    andNotNull(left) {
        return this.add(Filter.LogicalType.AND, left, Filter.ComparisonType.IsNotNull)
    }

    /**
     * add or condition filter
     * @param {...string} args left, right
     * @param {...string} args left, comparison, right
     * @returns {Filter}
     */
    or(...args) {
        if(args.length == 0 || args.length > 3) {
            throw new Error("Parameter is not valid")
        }

        if(args.length == 1 && !(args[0] instanceof Group)) {
            throw new Error("Parameter is not valid")
        }

        if(args.length == 1) {
            this.#filters.push(args[0])
            return
        }

        return args.length == 2 ?
            this.add(Filter.LogicalType.OR, args[0], Filter.ComparisonType.Equal, args[1]) :
            this.add(Filter.LogicalType.OR, args[0], args[1], args[2])
    }

    /**
     * add or between condition filter
     * @param {string} left
     * @param {Array} right
     * @returns {Filter}
     */
    orBetween(left, right) {
        return this.add(Filter.LogicalType.OR, left, Filter.ComparisonType.Between, right)
    }

    /**
     * add or in condition filter
     * @param {string} left
     * @param {Array} right
     * @returns {Filter}
     */
    orIn(left, right) {
        return this.add(Filter.LogicalType.OR, left, Filter.ComparisonType.In, right)
    }

    /**
     * add or is null condition filter
     * @param {string} left
     * @returns {Filter}
     */
    orNull(left) {
        return this.add(Filter.LogicalType.OR, left, Filter.ComparisonType.IsNull)
    }

    /**
     * add or is not null condition filter
     * @param {string} left
     * @returns {Filter}
     */
    orNotNull(left) {
        return this.add(Filter.LogicalType.OR, left, Filter.ComparisonType.IsNotNull)
    }

    /**
     * add custom condition
     * @param {string} logical
     * @param {string} left
     * @param {string} comparison
     * @param {string} right
     * @returns {Filter}
     */
    add(logical, left, comparison, right) {
        if(comparison == Filter.ComparisonType.Between) {
            if(!Array.isArray(right)) {
                throw new Error("If comparison is 'Between', then right condition must be array")
            }

            if(right.length != 2) {
                throw new Error("Length of right condition must be 2 item")
            }
        }

        if(comparison == Filter.ComparisonType.In) {
            if(!Array.isArray(right)) {
                throw new Error("If comparison is 'In', then right condition must be array")
            }
        }

        this.#filters.push(new Condition(logical, left, comparison, right))

        return this
    }

    /**
     * add group condition
     * @param {string} logical
     * @returns {Group}
     */
    group(logical = Filter.LogicalType.AND) {
        return new Group(logical)
    }

    get() {
        return this.#filters
    }
}