from enum import Enum, auto


class MonthTupleEnum(Enum):
    def _generate_next_value_(name, start, count, last_values):
        return (name[:3].lower(), count + 1)

    def describe(self):
        return (self.name.lower(), self.value)


class MonthsEnum(MonthTupleEnum):
    JANEIRO = auto()
    FEVEREIRO = auto()
    MARCO = auto()
    ABRIL = auto()
    MAIO = auto()
    JUNHO = auto()
    JULHO = auto()
    AGOSTO = auto()
    SETEMBRO = auto()
    OUTUBRO = auto()
    NOVEMBRO = auto()
    DEZEMBRO = auto()
