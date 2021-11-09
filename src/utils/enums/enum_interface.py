from enum import Enum

from abc import ABC, abstractmethod


class EnumInterface(ABC, Enum):
    @abstractmethod
    def describe(self, *args, **kwargs):
        pass
