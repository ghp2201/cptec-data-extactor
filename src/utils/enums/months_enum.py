from src.utils.enums.enum_interface import EnumInterface


class MonthTupleEnum(EnumInterface):
    def _generate_next_value_(name, start, count, last_values):
        return (name[:3].lower(), count + 1)

    def describe(self):
        return (self.name.lower(), self.value)


class MonthsEnum(MonthTupleEnum):
    JANUARY = auto()
    FEBRUARY = auto()
    MARCH = auto()
    APRIL = auto()
    MAY = auto()
    JUNE = auto()
    JULY = auto()
    AUGUST = auto()
    SEPTEMBER = auto()
    OCTOBER = auto()
    NOVEMBER = auto()
    DECEMBER = auto()
